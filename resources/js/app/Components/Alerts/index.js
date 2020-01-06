import React from 'react'

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {faExclamationCircle, faTimes, faCheckCircle, faExclamationTriangle, faBell} from '@fortawesome/free-solid-svg-icons'

import styled, {ThemeProvider} from  'styled-components';


const Box = styled.div`
    display: flex;
    background: ${props => props.theme.primary};
    color: #fff;
    border: 3px solid ${props => props.theme.secondary};
    align-items: center;
    border-radius: 8px;
`

const Icon = styled(FontAwesomeIcon)`
  padding: 0px 15px;
  background: ${props => props.theme.secondary};
  height: 52px;
`

const Exit = styled(FontAwesomeIcon)`
    padding: 0px 15px;
    margin: 5px;
    border-radius: 50px;
    height: 42px;
    cursor: pointer;

    &:hover {
        color: ${props => props.theme.secondary};
    }

`

const Message = styled.h5`
  margin: 0px;
  padding-left: 15px;
`

export function Error(props) {
    const theme = {
        primary: "#e72525",
        secondary: "#800505",
    }

    return (
        <ThemeProvider theme={theme}>
            <Box>
                <Icon icon={faExclamationCircle} />
                <Message>{props.message}</Message>
                <Exit icon={faTimes} />
            </Box>
        </ThemeProvider>
    )
}

export function Success(props) {
    const theme = {
        primary: "#0fb319",
        secondary: "#157c00",
    }

    return (
        <ThemeProvider theme={theme}>
            <Box>
                <Icon icon={faCheckCircle} />
                <Message>{props.message}</Message>
                <Exit icon={faTimes} />
            </Box>
        </ThemeProvider>
    )
}

export function Warning(props) {
    const theme = {
        primary: "#e48f17",
        secondary: "#824c00",
    }

    return (
        <ThemeProvider theme={theme}>
            <Box>
                <Icon icon={faExclamationTriangle} />
                <Message>{props.message}</Message>
                <Exit icon={faTimes} />
            </Box>
        </ThemeProvider>
    )
}

export function Notification(props) {
    const theme = {
        primary: "#020d77",
        secondary: "#000428",
    }

    return (
        <ThemeProvider theme={theme}>
            <Box>
                <Icon icon={faBell} />
                <Message>{props.message}</Message>
                <Exit icon={faTimes} />
            </Box>
        </ThemeProvider>
    )
}