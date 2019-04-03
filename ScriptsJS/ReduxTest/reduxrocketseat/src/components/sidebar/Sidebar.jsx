import React, { Component } from 'react';

class Sidebar extends Component {

    render () {
        const { modules } = this.state;
        return (
            <aside>
                {modules.map(module => (
                    <div key={module.id}>
                        <strong>{module.title}</strong>
                        <ul>{module.lessons.map(lesson => (
                            <li key={lesson.id}>{lesson.title}</li>
                        ))}
                        </ul>
                    </div>
                ))}
            </aside>
        );
    }
}

export default Sidebar;