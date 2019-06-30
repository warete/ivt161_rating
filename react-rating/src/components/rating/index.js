import React from 'react'
import "bootstrap/dist/css/bootstrap.css";
import RatingList from '../ratingList'
import { Route, Redirect } from 'react-router-dom'

class Rating extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div>
                <Route path={`${this.props.match.path}/:semester`} render={props => <RatingList semester={props.match.params.semester} />} />
                <Route
                    exact
                    path={this.props.match.path}
                    render={() => <Redirect to={`${this.props.match.path}/1`} />}
                />
            </div>
        )
    }
}

export default Rating