const WindowsToaster = require('node-notifier').WindowsToaster;
const fs = require('fs');
const path = require('path');
const watch = require('node-watch');
const readCache = require('read-cache');

const sendNotification = (project, type) => {
    let notifier = new WindowsToaster({
        withFallback: false, // Fallback to Growl or Balloons?
        customPath: void 0 // Relative/Absolute path if you want to use your fork of SnoreToast.exe
    });

    const logType = wichLog(type) === 'path_debug' ? "Debug" : "Erro";

    notifier.notify(
        {
            title: `${logType} em ${project.name}`,
            message: `O projeto ${project.name} que você está depurando possui um novo ${logType}`,
            icon: `${__dirname}/renderer/assets/icons/64x64.png`, // String. Absolute path to Icon
            sound: true, // Bool | String (as defined by http://msdn.microsoft.com/en-us/library/windows/apps/hh761492.aspx)
            wait: true, // Bool. Wait for User Action against Notification or times out
            id: void 0, // Number. ID to use for closing notification.
            appID: void 0, // String. App.ID and app Name. Defaults to no value, causing SnoreToast text to be visible.
            remove: void 0, // Number. Refer to previously created notification to close.
            install: void 0 // String (path, application, app id).  Creates a shortcut <path> in the start menu which point to the executable <application>, appID used for the notifications.
        },
        function (error, response) {
            console.log(response);
        }
    );

};

let watcher = undefined;
let count = 0;

const wichLog = type => (type === 'debug') ? "path_debug" : "path_error";

if (watcher !== undefined) {
    delete watcher;
    count = 0;
}

const project = {name: "Esse projeto", path_debug: "C:\\Users\\Daniel\\Desktop\\teste.txt"};

const type = "debug";

const read = () => {
    readCache(path.resolve(path.resolve(project[wichLog(type)])), 'utf8')
        .then(contents => {
            sendNotification(project, type);
            count = contents.length;
        });
};

read();
watcher = watch(path.resolve(project[wichLog(type)]), (evt, name) => {
    if (evt === "update") {
        read();
    }
});
