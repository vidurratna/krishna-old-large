import React from 'react'
import styled from  'styled-components';

export const Grid = styled.div`
    display: grid;
`


export default function index(props) {
    return (
        <div>
            <div>
                <div>
                    stuff
                </div>
                <props.header/>
            </div>
            <div>
                <div>
                    stufffff
                </div>
                <props.content/>
            </div>
        </div>
    )
}
