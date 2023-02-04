import React, { useState } from 'react';

const ConfirmationPopup = ({ message, onCancel }) => {
  const [showPopup, setShowPopup] = useState(false);

  return (
    <div>
      <button type="button" onClick={() => setShowPopup(true)}>Confirm</button>
      {showPopup && (
        <div style={{ backgroundColor: 'white', padding: '10px' }}>
          <p>{message}</p>
          <button type="submit">Yes</button>
          <button type="button" onClick={() => setShowPopup(false)}>No</button>
        </div>
      )}
    </div>
  );
};

export default ConfirmationPopup;