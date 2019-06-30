import React from 'react'
import "bootstrap/dist/css/bootstrap.css";
import { Row, ButtonGroup, Button } from "react-bootstrap";
import { config } from '../../config'
import RatingRow from '../ratingRow'
import { Link, NavLink } from 'react-router-dom'

class RatingList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            rating: [],
            search: null,
            semesters: [
                'Первый', 'Второй', 'Третий', 'Четвертый', 'Пятый', 'Шестой', 'Седьмой', 'Восьмой'
            ],
            currentSemester: 1
        };
    }

    componentDidMount() {
        fetch(`${config.apiUrl}?sem=${this.state.currentSemester}`).then(res => res.json()).then(json => {
            this.setState({ rating: json });
        });
        this.setState({ currentSemester: this.props.semester });
    }

    componentWillReceiveProps(nextProps) {
        if (nextProps.semester !== this.state.currentSemester) {
            this.setState({ currentSemester: nextProps.semester });
            fetch(`${config.apiUrl}?sem=${nextProps.semester}`).then(res => res.json()).then(json => {
                this.setState({ rating: json });
            });
        }
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
                <Row>
                    { this.state.semesters.map((item, i) => (
                        <NavLink key={ `${item} семестр` } to={ `/rating/${ i + 1 }` } className="list-group-item col-md-3">{ `${item} семестр` }</NavLink>
                    )) }
                </Row>
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

export default RatingList