import React, { useState, useEffect } from 'react';

const CSVReader = () => {
  const [data, setData] = useState([]);
  const [headers, setHeaders] = useState([]);
  const [file, setFile] = useState(null);

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
          if (character === '"') {
            withinQuotations = !withinQuotations;
            continue;
          }

          if (character === ',' && !withinQuotations) {
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
      setData(d);
    };

    reader.onerror = (error) => {
      console.log('An error occurred while reading the file: ', error);
    };

    reader.readAsText(f);
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    console.log('Submitting file: ', file.name);
    console.log('Headers: ', headers);
    console.log('Data: ', data);
  };

  return (
    <div>
      <form onSubmit={handleSubmit}>
        <input type="file" onChange={handleFileUpload} />
        <button type="submit">Submit</button>
      </form>
      <table>
        <thead>
          <tr>
            {headers.map((header) => (
              <th key={header}>{header}</th>
            ))}
          </tr>
        </thead>
        <tbody>
          {data.map((row, index) => (
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

export default CSVReader;
