import React, {useEffect, useState} from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter, Switch, Route, Link} from 'react-router-dom';
import Table from './table';
import Fixtures from './fixtures';

function App() {


	return (
		<BrowserRouter>
			<div className="container">
				<nav className="navbar navbar-expand-lg navbar-dark bg-dark ">
					<a
						className="navbar-brand"
						href="#">Navbar
					</a>
					<button
						className="navbar-toggler"
						type="button"
						data-toggle="collapse"
						data-target="#navbarNavAltMarkup"
						aria-controls="navbarNavAltMarkup"
						aria-expanded="false"
						aria-label="Toggle navigation">
						<span className="navbar-toggler-icon" />
					</button>
					<div
						className="collapse navbar-collapse"
						id="navbarNavAltMarkup">
						<div className="navbar-nav">

							<Link
								className="nav-item nav-link active"
								to="/">League Table</Link>
							<Link
								className="nav-item nav-link"
								to="/fixtures">Fixtures</Link>
						</div>
					</div>
				</nav>
				<Switch>
					<Route path="/fixtures" component={Fixtures} />
					<Route
						path="/"
						component={Table} />

				</Switch>

			</div>
		</BrowserRouter>

	);
}

export default App;

if (document.getElementById('app')) {
	ReactDOM.render(<App />, document.getElementById('app'));
}
