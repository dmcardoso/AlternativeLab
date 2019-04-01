'use strict'

import React from 'react';

const UserInfo = () => {
  return (
    <div className="user-info">
      <img src="https://avatars0.githubusercontent.com/u/28882783?v=4" alt=""/>
      <h1><a href="https://github.com/dmcardoso">DanielMoreira</a></h1>
      <ul className="repos-info">
        <li>- Repositórios: 8</li>
        <li>- Seguidores: 10</li>
        <li>- Seguindo: 10</li>
      </ul>
    </div>
  );
};

export default UserInfo;