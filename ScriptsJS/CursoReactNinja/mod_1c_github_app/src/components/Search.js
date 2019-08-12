'use strict';
import React from 'react';

const Search = ({ searchFunc }) => {
    return (
        <div className="search">
            <input
                type="search"
                placeholder="Digite o nome do usuário no Github"
                onChange={searchFunc}
            />
        </div>
    );
};

export default Search;