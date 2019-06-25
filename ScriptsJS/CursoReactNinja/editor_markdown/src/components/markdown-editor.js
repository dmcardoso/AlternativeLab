import React, {PropTypes} from 'react';

const MarkdownEditor = ({value, handleChange, getMarkUp}) => {
  return (
    <div className='editor'>
      <textarea value={value} onChange={handleChange} autoFocus />
      <div className='view' dangerouslySetInnerHTML={getMarkUp()} />
    </div>
  );
};

MarkdownEditor.propTypes = {
  value: PropTypes.string.isRequired,
  handleChange: PropTypes.func.isRequired
};

export default MarkdownEditor;
