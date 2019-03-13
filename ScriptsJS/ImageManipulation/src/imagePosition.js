const calculateImageCenter = ({imageWidth, imageHeight, markWidth, markHeight}) => {
    const x = calculateCenter({imageSize: imageWidth, markSize: markWidth});
    const y = calculateCenter({imageSize: imageHeight, markSize: markHeight});

    return {x, y};
};

const calculateCenter = ({imageSize, markSize}) => ((imageSize - markSize) / 2);

module.exports = {calculateImageCenter};
