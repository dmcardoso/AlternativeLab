import axios from 'axios';

const Request = function () {

    const requests = [];

    this.set = (api, method, params = {}, callback) => {

        const id = `${api}-${makeid()}`;

        requests.push({ id, api, method, params, callback });

        return id;
    };

    this.execute = () => {

    };

    const makeid = () => {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 8; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

};

export { Request };