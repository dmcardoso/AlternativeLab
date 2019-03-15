const calculateImageCenter = ({imageWidth, imageHeight, markWidth, markHeight}) => {
    const x = calculateCenter({imageSize: imageWidth, markSize: markWidth});
    const y = calculateCenter({imageSize: imageHeight, markSize: markHeight});

    return {x, y};
};

const calculateCenter = ({imageSize, markSize}) => ((imageSize - markSize) / 2);

const center = (imageWidth, imageHeight, markWidth, markHeight) => {
    return calculateImageCenter({imageWidth, imageHeight, markWidth, markHeight});
};

const calculateImageLeftBottom = ({imageHeight, markHeight, marginY, marginX}) => {
    const x = marginX;
    const y = imageHeight - (markHeight + marginY);

    return {x, y};
};

const calculateImageLeftTop = ({marginX, marginY}) => {
    const x = marginX;
    const y = marginY;

    return {x, y};
};

const calculateImageRightBottom = ({imageWidth, imageHeight, markWidth, markHeight, marginY, marginX}) => {
    const x = imageWidth - markWidth - marginX;
    const y = imageHeight - (markHeight + marginY);

    return {x, y};
};

const calculateImageRightTop = ({imageWidth, markWidth, marginY, marginX}) => {
    const x = imageWidth - markWidth - marginX;
    const y = marginY;

    return {x, y};
};

const left = (marginX = 0, marginY = 0, imageHeight = 0, markHeight = 0, top = false) => {
    if (imageHeight === true) {
        top = true;
    }

    if (top) {
        return calculateImageLeftTop({marginX, marginY});
    } else {
        return calculateImageLeftBottom({imageHeight, markHeight, marginY, marginX});
    }
};


const rigth = (marginX = 0, marginY = 0, imageWidth = 0, markWidth = 0, imageHeight = 0, markHeight = 0, top = false) => {
    if (imageHeight === true) {
        top = true;
    }

    if (top) {
        return calculateImageRightTop({imageWidth, markWidth, marginY, marginX});
    } else {
        return calculateImageRightBottom({imageWidth, imageHeight, markWidth, markHeight, marginY, marginX});
    }
};

module.exports = {center, left, rigth};