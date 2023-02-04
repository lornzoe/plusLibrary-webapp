import React, { useState } from 'react';

const ConfirmationPopup = ({ message, onConfirm, onCancel }) => {
  const [showPopup, setShowPopup] = useState(false);

  return (
    <div>
      <button onClick={() => setShowPopup(true)}>Confirm</button>
      {showPopup && (
        <div style={{ backgroundColor: 'white', padding: '10px' }}>
          <p>{message}</p>
          <button onClick={onConfirm}>Yes</button>
          <button onClick={() => setShowPopup(false)}>No</button>
        </div>
      )}
    </div>
  );
};

export default ConfirmationPopup;