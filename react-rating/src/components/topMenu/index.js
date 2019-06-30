import React from 'react'
import "bootstrap/dist/css/bootstrap.css";
import { Navbar, Nav, Container, NavItem } from "react-bootstrap";
import { Link, NavLink } from 'react-router-dom'

export default () => {
    return (
        <Navbar bg="dark" variant="dark" collapseOnSelect expand="lg" >
            <Container>
                <Navbar.Brand as={Link} to="/">ИВТ-161</Navbar.Brand>
                <Navbar.Toggle aria-controls="basic-navbar-nav" />
                <Navbar.Collapse id="basic-navbar-nav">
                    <Nav className="ml-auto">
                        <Nav.Link as={NavLink} to="/">Главная</Nav.Link>
                        <Nav.Link as={NavLink} to="/schedule">Расписание</Nav.Link>
                        <Nav.Link as={NavLink} to="/rating">Рейтинг</Nav.Link>
                        <Nav.Link as={NavLink} to="/materials">Материалы</Nav.Link>
                    </Nav>
                </Navbar.Collapse>
            </Container>
        </Navbar>
    )
}