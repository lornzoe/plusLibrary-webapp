import React, { useState } from 'react';

const CSVReader = () => {
  const [data, setData] = useState([]);

  const handleFileUpload = (event) => {
    const file = event.target.files[0];

    if (!file) return;
    if (!file.type.match('text/csv')) {
      alert('Please upload a valid .csv file.');
      return;
    }

    const reader = new FileReader();
    reader.onload = (event) => {
      const csvData = event.target.result;
      const rows = csvData.split('\n').slice(0, -1);
      const headers = rows[0].split(',');
      const parsedData = rows.slice(1).map((row) => {
        const cells = row.split(',');
        return headers.reduce((acc, header, index) => {
          acc[header] = cells[index];
          return acc;
        }, {});
      });
      setData(parsedData);
    };
    reader.readAsText(file);
  };

  return (
    <div>
      <input type="file" accept=".csv" onChange={handleFileUpload} />
      <table>
        <thead>
          <tr>
            {data.length > 0 && Object.keys(data[0]).map((header) => (
              <th key={header}>{header}</th>
            ))}
          </tr>
        </thead>
        <tbody>
          {data.map((row, index) => (
            <tr key={index}>
              {Object.values(row).map((cell) => (
                <td key={cell}>{cell}</td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default CSVReader;
