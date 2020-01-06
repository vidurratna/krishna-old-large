import React from 'react';
import ReactDOM from 'react-dom';

import App from './App';

import { createStore } from 'redux';
import { Provider } from 'react-redux';

import rootReducer from './Redux/Reducers';

import CssBaseline from '@material-ui/core/CssBaseline';


const saveState = (state) => {
    try {
        const serializedState = JSON.stringify(state);

        window.localStorage.setItem('krishna_state', serializedState);
    } catch (err) {
    }
};

const loadState = () => {
    try {
        const serializedState = window.localStorage.getItem('krishna_state');

        if(!serializedState) return undefined;
        return JSON.parse(serializedState);
    } catch (err) {
        return undefined
    }
};

const oldState = loadState();

const store = createStore(rootReducer, oldState);

store.subscribe(() => {
    saveState(store.getState());
});

if (document.getElementById('app')) {
    ReactDOM.render(
        <Provider store={store}>
            <App />
        </Provider>
    , document.getElementById('app'));
}
