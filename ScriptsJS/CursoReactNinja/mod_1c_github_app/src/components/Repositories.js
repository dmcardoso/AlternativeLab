'use strict';

import React from 'react';

const Repositories = (props) => {
    return (
        <div className={props.class}>
            <h2>{props.title}</h2>
            <ul>
                {props.repos.map((repo) =>
                    <li key={repo.link}><a href={repo.link}>{repo.name}</a></li>
                )}
            </ul>
        </div>
    );
};

Repositories.defaultProps = {
    class: '',
};

Repositories.propTypes = {
    class: React.PropTypes.string,
    title: React.PropTypes.string.isRequired,
    repos: React.PropTypes.array,
};

export default Repositories;