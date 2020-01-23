import styled, {keyframes} from  'styled-components';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

const fadeIn = keyframes`
  from {
    opacity: 0.0;
  }

  to {
    opacity: 1;
  }
`;

export const Table = styled.table`
    width: 100%;
    background-color: #343434;
    color: #fff;
    tbody {
        tr:nth-child(even) {background-color: #1f1f1f;}
    }
    th, td {
        padding: 15px;
        
      }
`

export const TableHead = styled.thead`
    text-align: left;
    background-color: #1f1f1f;
`

export const TableRow =styled.tr`
    text-align: left;
    background-color: #fff;
`


export const ShortCutHolder = styled.div`
    padding: ${props=>props.small ? "0px" :"15px 0px"};
    display: flex;
    padding-right: 15px;
`

export const Container = styled.div`
    padding: 30px;
    color: #e0e0e0;
    animation: ${fadeIn} 0.5s linear;

    
`

export const EditIcon = styled(FontAwesomeIcon)`
    cursor: pointer;
    margin: auto;
    display: flex;
    padding: 5px 10px;
    color: #fff;
    
    &:hover {
        color: #cecece;
    }
`

export const Filter = styled.h3`
    margin: 0;
    padding: 5px;
    cursor: pointer;
    transition: 0.3s;
    border-radius: 4px;

    ${props => props.active ? "color: #dc2727;": null}

    &:hover {
        background: #404040;
        color: ${props => props.active ? "#dc2727": "#fff"};
    }
`

export const FilterTitle = styled.h5`
    margin: 0;
    padding: 5px;
`

export const FilterHolder = styled.div`
    margin: 0;
`