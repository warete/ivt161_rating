import React from 'react';
import "bootstrap/dist/css/bootstrap.css";
import { Container } from "react-bootstrap";
import TopMenu from '../topMenu'
import { Switch, Route } from 'react-router-dom'
import Schedule from '../schedule'
import Rating from '../rating'
import Materials from '../materials'

function App() {
  return (
      <div>
          <TopMenu />
          <Container>
              <Switch>
                  <Route exact path="/" component={Schedule}/>
                  <Route path="/schedule" component={Schedule}/>
                  <Route path="/rating" component={Rating}/>
                  <Route path="/materials" component={Materials}/>
              </Switch>
          </Container>
      </div>
  );
}

export default App;
