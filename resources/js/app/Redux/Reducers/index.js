import { combineReducers } from 'redux';

import Auth from './Authenticate';
import App from './App'

export default combineReducers({
    Auth,
    App,
})