require('./bootstrap');

import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter } from 'react-router-dom'

import App from './App';
import Authorize from './Static/Authorize';
import AuthRejected from './Static/Errors/AuthRejected';
import RequestRejected from './Static/Errors/RequestRejected';

if (!! document.getElementById('app')) {
    ReactDOM.render((
      <BrowserRouter>
          <App />
      </BrowserRouter>
    ), document.getElementById('app'))
}

if (!! document.getElementById('authorize')) {
    ReactDOM.render(
      <Authorize />,
      document.getElementById('authorize')
    );
}

if (!! document.getElementById('auth_rejected')) {
    ReactDOM.render(
      <AuthRejected />,
      document.getElementById('auth_rejected')
    );
}

if (!! document.getElementById('request_rejected')) {
    ReactDOM.render(
      <RequestRejected />,
      document.getElementById('request_rejected')
    );
}