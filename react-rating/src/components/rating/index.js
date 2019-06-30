import React from 'react'
import "bootstrap/dist/css/bootstrap.css";
import { Table, Card } from "react-bootstrap";
import { config } from '../../config'
import RatingRow from '../ratingRow'

class Rating extends React.Component {
    constructor() {
        super();
        this.state = {
            rating: [],
            search: null
        };
    }

    componentDidMount() {
        fetch(config.apiUrl).then(res => res.json()).then(json => {
            this.setState({ rating: json });
        });
    }

    get rating() {
        return (this.state.search !== null && String(this.state.search).length) ? (
            this.state.rating.filter(item => {
                return String(item.STUDENT.INFO).toLowerCase().includes(this.state.search)
            })
        ) : this.state.rating;
    }

    dataSearch = (e) => {
        const value = e.target.value.toLowerCase();
        this.setState({ search: value });
    };

    render() {
        const { rating, dataSearch } = this;
        return (
            <div>
                <input
                    type="text"
                    className="form-control my-2"
                    placeholder="Начните вводить имя..."
                    onChange={dataSearch}
                    autoFocus
                />
                { rating.map((item) => (
                    <RatingRow key={`studentRating${item.STUDENT.ID}`} data={ item }/>
                )) }
            </div>
        )
    }
}

export default Rating