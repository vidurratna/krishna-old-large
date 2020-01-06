import React from 'react'

import styled from  'styled-components';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faArrowRight, faSpinner } from '@fortawesome/free-solid-svg-icons';
import { device } from '../../constants';


const Input = styled.button`
    padding: 20px;
    margin: 30px 0px;
    width: 45%;
    color: #fff;
    border-radius: 5px;
    background: #55514e;
    transition: 0.3s;
    border: 2px solid #6c402c;
    cursor: pointer;
    font-weight: 700;
    font-size: 18px;

    &:hover {
        background: #a9866c;
    }

    @media ${device.laptop} {
        font-size: 16px;
        width: auto;
    }

    @media ${device.tablet} {
        font-size: 14px;
    }
`

export default function Submit(props) {
    return (
            <Input
            type="submit"
            >
                {props.text || "Submit"} <FontAwesomeIcon spin={props.loading} icon={props.loading ? faSpinner  : faArrowRight}/>
            </Input>
    )
}
