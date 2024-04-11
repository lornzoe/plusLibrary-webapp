import React, { useState, useEffect } from 'react';
import ConfirmationPopup from '@/Components/ConfirmationPopup';
import { useForm, Head } from '@inertiajs/inertia-react';

export default function CSVReader({postRoute = 'fillables.store'}) {
  const [array, setArray] = useState([]);
  const [headers, setHeaders] = useState([]);
  const [file, setFile] = useState(null);
  
  const [isConfirmed, setIsConfirmed] = useState(false);
  const [csrfToken, setCsrfToken] = useState('');
 
  const { data, setData, post, processing, reset, errors } = useForm({
    message: [],
  });

  useEffect(() => {
    console.log('Data updated', data);
  }, [data]);

  const handleFileUpload = (event) => {
    const f = event.target.files[0];

    if (!f) return;
    if (!f.type.match('text/csv')) {
      alert('Please upload a valid .csv file.');
      return;
    }

    setFile(f);

    const reader = new FileReader();
    reader.onload = (e) => {
      const csv = e.target.result;
      if (!csv) {
        console.log('No data available');
        return;
      }

      const rows = csv.split('\n').slice(0, -1);
      const h = rows[0].split(',').map((header) => header.replace(/\r/g, ''));
      const d = rows.slice(1).map((row) => {

        const cells = [];
        let currentCell = '';
        let withinQuotations = false;

        for (const character of row) {
          if (character == /\r/g)
          {
            continue;
          }

          if (character === '"') {
            withinQuotations = !withinQuotations;
            continue;
          }

          else if (character === ',' && !withinQuotations) {
            cells.push(currentCell);
            currentCell = '';
            continue;
          }

          currentCell += character;
        }

        cells.push(currentCell);
        return h.reduce((acc, header, index) => {
          acc[header] = cells[index];
          return acc;
        }, {});
      });
      
      setHeaders(h);
      setArray(d);
      setData('message', d);
      console.log(data);
    };

    reader.onerror = (error) => {
      console.log('An error occurred while reading the file: ', error);
    };

    reader.readAsText(f);
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    setIsConfirmed(true);
    console.log('handleSubmit');
    
    post(route(postRoute), { onSuccess: () => reset() });

    // const formData = new FormData();
    // formData.append('_token', csrfToken);
    // formData.append('file', file);

    // console.log(formData);

    // fetch(route('csv.upload'), {
    //   method: 'POST',
    //   body: formData
    // })
    //   .then(res => res.json())
    //   .then(res =>{
    //     if (res.success) {
    //       console.log('File uploaded successfully!');
    //     } else {
    //       console.log('File upload failed.');
    //     } 
    //   })
    //   .catch(error => {
    //     console.error(error);
    //   });
  };

  // React.useEffect(() => {
  //   fetch('/csrf-token')
  //     .then((res) => res.json())
  //     .then((res) => {
  //       setCsrfToken(res._token);
  //     });
  // }, []);

  const handleDataCheck = (event) =>{
    event.preventDefault();
    console.log('Submitting file: ', file.name);
    console.log('Headers: ', headers);
    console.log('Data: ', data);
  }

  return (
    <div>
      <form onSubmit={handleSubmit}>
        <input type="file" onChange={handleFileUpload} />
        <button type="button" onClick={handleDataCheck}>Data Check</button>
        {isConfirmed ? (
        <p>Action confirmed</p>
      ) : (
        <ConfirmationPopup
          message="Are you sure you want to submit this?"
          onCancel={() => console.log('Cancelled')}
        />
      )}
      </form>
      <div>
      
    </div>
      <table>
        <thead>
          <tr>
            {headers.map((header) => (
              <th key={header}>{header}</th>
            ))}
          </tr>
        </thead>
        <tbody>
          {array.map((row, index) => (
            <tr key={index}>
              {headers.map((header) => (
                <td key={header}>{row[header]}</td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};
