const calculateAspectRatio = (width, height) => width / height;
const calculateImageProportions = (width, height) => {
    const maxWidth = 1360;
    const maxHeight = 1360;
    const ratio = calculateAspectRatio(width, height);

    let newWidth = maxWidth, newHeight = maxHeight;

    if ((maxWidth/maxHeight) > ratio) {
        newWidth = maxHeight * ratio;
    } else {
        newHeight = maxWidth / ratio;
    }

    return {newWidth, newHeight};
};

module.exports = {calculateImageProportions};