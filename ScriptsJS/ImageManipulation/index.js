const Jimp = require('jimp');
const path = require('path');
//if you are following along, create the following 2 images relative to this script:
let imgRaw = path.resolve(__dirname, 'old_images/daniel.png'); //a 1024px x 1024px backgroound image
let imgLogo = path.resolve(__dirname, 'old_images/logo.png'); //a 155px x 72px logo
//---

let imgActive = path.resolve(__dirname, 'new_images/active.jpg');
let imgExported = path.resolve(__dirname, 'new_images/exported.jpg');

let textData = {
    text: 'Daniel Moreira google logo', //the text to be rendered on the image
    maxWidth: 640, //image width - 10px margin left - 10px margin right
    maxHeight: 72 + 20, //logo height + margin
    placementX: 10, // 10px in on the x axis
    placementY: 640 - (72 + 20) - 10 //bottom of the image: height - maxHeight - margin
};

//read template & clone raw image 
Jimp.read(imgRaw)
    .then(tpl => {
        return (tpl.clone().write(imgActive));
    })

    //read cloned (active) image
    .then(() => (Jimp.read(imgActive)))

    //combine logo into image
    .then(tpl => {

            const width_image = tpl.bitmap.width;
            const height_image = tpl.bitmap.height;

            return Jimp.read(imgLogo).then(logoTpl => {
                logoTpl.opacity(0.2);
                logoTpl.resize((width_image / 3), (height_image / 3));
                return tpl.composite(logoTpl, ((width_image - (width_image / 3)) / 2), ((height_image - (height_image / 3)) / 2), [Jimp.BLEND_DESTINATION_OVER, 0.2, 0.2]);
            })
        }
    )

    //load font
    .then(tpl => (
        Jimp.loadFont(Jimp.FONT_SANS_32_WHITE).then(font => ([tpl, font]))
    ))

    //add footer text
    .then(data => {

        tpl = data[0];
        const font = data[1];

        return tpl.print(font, textData.placementX, textData.placementY, {
            text: textData.text,
            alignmentX: Jimp.HORIZONTAL_ALIGN_CENTER,
            alignmentY: Jimp.VERTICAL_ALIGN_MIDDLE
        }, textData.maxWidth, textData.maxHeight);
    })

    //export image
    .then(tpl => (tpl.quality(100).write(imgExported)))

    //log exported filename
    .then(tpl => {
        console.log(path.resolve(__dirname, 'exported file: ') + imgExported);
    })

    //catch errors
    .catch(err => {
        console.error(err);
    });

