import React from 'react'
import "bootstrap/dist/css/bootstrap.css";
import { Table, Card } from "react-bootstrap";

class RatingRow extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <Card bg="dark" text="light" className="mb-2">
                <Card.Header className="bg-success">{ this.props.data.STUDENT.INFO }</Card.Header>
                <Card.Body style={{padding: 0}}>
                    <Table striped hover variant="dark">
                        <tbody>
                        { this.props.data.RATING.map((item) => (
                            <tr>
                                <td>{ item.SUBJECT.NAME }</td>
                                <td>{ item.SUBJECT.TYPE }</td>
                                <td>{ item.RESULT }</td>
                            </tr>
                        )) }
                        </tbody>
                    </Table>
                </Card.Body>
            </Card>
        )
    }
}

export default RatingRow