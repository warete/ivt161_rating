import React from 'react'
import "bootstrap/dist/css/bootstrap.css";
import { Table, Card } from "react-bootstrap";
import { config } from '../../config'
import RatingRow from '../ratingRow'

class Rating extends React.Component {
    constructor() {
        super();
        this.state = {
            rating: []
        };
    }

    componentDidMount() {
        fetch(config.apiUrl).then(res => res.json()).then(json => {
            this.setState({ rating: json });
        });
    }

    render() {
        return (
            <div>
                { this.state.rating.map((item) => (
                    <RatingRow key={`studentRating${item.STUDENT.ID}`} data={ item }/>
                )) }
            </div>
        )
    }
}

export default Rating