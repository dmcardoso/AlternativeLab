const calculateAspectRatio = (width, height) => width / height;
const calculateImageProportions = (width, height) => {
    const maxWidth = 210;
    const maxHeight = 210;
    const ratio = calculateAspectRatio(width, height);

    let newWidth = maxWidth, newHeight = maxHeight;

    if ((maxWidth/maxHeight) > ratio) {
        newWidth = maxHeight * ratio;
    } else {
        newHeight = maxWidth / ratio;
    }

    return {width: newWidth, height: newHeight};
};

module.exports = {calculateImageProportions};