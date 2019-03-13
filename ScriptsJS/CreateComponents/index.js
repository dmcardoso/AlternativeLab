#!/usr/bin/env node

const path = require('path');
const fs = require('fs');
require('./src/types_extend');
const yargs = require('yargs').argv;
const colors = require('colors');
const {react_component, react_class_component} = require('./file_templates/react_templates.js');

const executionPath = process.cwd();

const buildComponentStructure = (component, types, sources) => {
    const writeFile = (component, type, src = "") => fs.writeFileSync(path.resolve(executionPath, component, `${component}.${type}`), src);
    const getSource = (type, sources) => sources[type] !== undefined ? sources[type] : "";

    if (!fs.existsSync(path.resolve(executionPath, component))) {
        fs.mkdirSync(path.resolve(executionPath, component));

        types.forEach((type) => {
            console.log(`${colors.blue('Creating:')} ${colors.yellow(path.resolve(executionPath, component, `${component.capitalizeFirstLetter()}.${type}`))}`);
            writeFile(component.capitalizeFirstLetter(), type, getSource(type, sources));
            console.log(`${colors.green("Successfully!")}`);
        });
    } else {
        console.log(`${colors.yellow(path.resolve(executionPath, component))} ${colors.red('already exists. Trying to create files components:')}`);

        types.forEach((type) => {
            if (!fs.existsSync(path.resolve(executionPath, component, `${component.capitalizeFirstLetter()}.${type}`))) {
                console.log(`${colors.blue('Creating:')} ${colors.yellow(path.resolve(executionPath, component, `${component.capitalizeFirstLetter()}.${type}`))}`);
                writeFile(component.capitalizeFirstLetter(), type, getSource(type, sources));
                console.log(`${colors.green("Successfully!")}`);
            } else {
                console.log(`${colors.red("Failed to create file component")} ${colors.yellow(path.resolve(executionPath, component, `${component.capitalizeFirstLetter()}.${type}`))} ${colors.red(', it already exists.')}`);
            }
        });
    }
};

if (yargs['react-component']) {
    const reactComponent = yargs['react-component'];
    const expectedTypes = ['jsx'];
    let typeStyle = "";

    if (yargs['with'] && yargs['with'] === "scss") {
        expectedTypes.push('scss');
        typeStyle = 'scss';
    } else {
        expectedTypes.push('css');
        typeStyle = 'css';
    }

    const sources = {
        jsx: ''
    };

    if (yargs['class']) {
        sources.jsx = react_class_component({name: yargs['react-component'].capitalizeFirstLetter(), typeStyle}).trim();
    } else {
        sources.jsx = react_component({name: yargs['react-component'].capitalizeFirstLetter(), typeStyle}).trim();
    }

    buildComponentStructure(reactComponent, expectedTypes, sources);
}