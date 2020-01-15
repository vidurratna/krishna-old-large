import React from 'react'
import Notify from './Notify'
import { api } from './Api';

export default function Services() {

    //Set up API Auth

    try {
        const serializedAuthToken = window.localStorage.getItem('krishna_token');

        if(serializedAuthToken){
            api.interceptors.request.use(function (config) {
                config.headers = {...config.headers, "authorization": "Bearer "+serializedAuthToken}
                return config;
            }, function( error ) {
                // null
            })
        }

    } catch (err) {
        // null
    }

    return (
        <Notify/>
    )
}
