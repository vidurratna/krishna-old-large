import React, { useState, useEffect } from 'react'

import CssBaseline from '@material-ui/core/CssBaseline'
import { BrowserRouter } from 'react-router-dom'
import { ThemeProvider } from '@material-ui/core/styles'

import {AppContext} from './Provider/appContext'

import theme from './theme'
import Routes from './Routes'
import Setup from './Services/Setup'

const loadState = () => {

  let initInfo={
    chapter: {name:"Krishna"},
    user: null,
    level: 99,
  }

  try {
      const serializedState = window.localStorage.getItem('krishna_state');

      if(!serializedState) return initInfo;
      return JSON.parse(serializedState);
  } catch (err) {
      return initInfo
  }
};

export default function App() {

    const update = (info) => {
      setState({...state,chapter: info})
    }

    const setUser = (user) => {
      setState({...state,user: user})
    }

    const [state, setState] = useState({
      ...loadState(),
      update: update,
      setUser: setUser
    })

    useEffect(()=>{
      const serializedState = JSON.stringify(state);
      window.localStorage.setItem('krishna_state', serializedState);
    })

    return (
        <React.Fragment>
          <CssBaseline/>
          <BrowserRouter>
            <ThemeProvider theme={theme}>
              <AppContext.Provider value={state}>
                <Routes/>
                <Setup/>
              </AppContext.Provider>
            </ThemeProvider>
          </BrowserRouter>
        </React.Fragment>
    )
}
