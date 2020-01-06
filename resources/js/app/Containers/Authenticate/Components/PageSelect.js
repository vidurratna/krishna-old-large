import React from 'react'

import styled from  'styled-components';

const Holder = styled.div`
    display: block;
`

const Line = styled.div`
    height: 8px;
    background: #02001e;
    width: 80%;
    top: 32px;
    position: relative;
`

const BallHolder = styled.div`
    display: flex;
    justify-content: space-between;
    width: 80%;
`

const Ball = styled.div`
    background: ${props => props.selected ? "#55514e" : "#fff"};
    color: ${props => props.selected ? "#fff" : "#55514e"};
    border: 3px solid #55514e;
    width: 50px;
    display: flex;
    transition: 0.3s;
    height: 50px;
    border-radius: 47px;

    cursor: pointer;

    z-index: 5;

    &:hover {
        background: ${props => props.selected ? "#a9866c" : "#55514e"};
        color: #fff;
    }

    & h1 {
        margin: auto;
    }
`

export default function PageSelect(props) {
    return (
        <Holder>
            <Line/>
            <BallHolder>
                <Ball onClick={() => props.change(1)} selected={props.page === 1} ><h1>1</h1></Ball>
                <Ball onClick={() => props.change(2)} selected={props.page === 2} ><h1>2</h1></Ball>
                <Ball onClick={() => props.change(3)} selected={props.page === 3} ><h1>3</h1></Ball>
            </BallHolder>
        </Holder>
    )
}
