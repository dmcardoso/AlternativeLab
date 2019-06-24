const id = 58;
const alias = 'feedback';

const templates = {
    add: 'Novo {alias} adicionado',
    edit: '{alias}: {id} alterado',
    remove: '{alias}: {id} removido'
};

const templateReplace = (template_id, args) => {
    let template = templates[template_id];

    Object.entries(args).forEach(([i, v], ii) => {
        template = template.replace(`{${i}}`, v);
    });

    console.log(template.charAt(0).toUpperCase() + template.substr(1));
};

// templateReplace('remove', {
//     id, alias
// });

class SystemLog {
    constructor (templates = null) {
        this.templates = {
            add: 'Novo {alias} adicionado',
            edit: '{alias}: {id} alterado',
            remove: '{alias}: {id} removido',
            ...templates,
        };
    }

    getLog (template_id, args) {
        let template = templates[template_id];

        Object.entries(args).forEach(([i, v], ii) => {
            template = template.replace(`{${i}}`, v);
        });

        return template.charAt(0).toUpperCase() + template.substr(1);
    }

    renderLog(log, args){
        let new_log = '';

        Object.entries(args).forEach(([i, v], ii) => {
            new_log = log.replace(`{${i}}`, v);
        });

        return template.charAt(0).toUpperCase() + template.substr(1);
    }

    getTemplates(){
        return this.templates;
    }

}

class FeedBack extends SystemLog {
    constructor () {
        super(
            {
                test: 'Testando'
            }
        );

        console.log(this.getTemplates());
    }
}

new FeedBack();