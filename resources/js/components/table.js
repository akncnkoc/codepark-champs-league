import React, {useEffect, useState} from 'react';

function Table() {
	const API_URL = "http://127.0.0.1:8000/api/v1";
	const [teams, setTeams] = useState([]);

	useEffect(() => {
		getTables();
	}, []);

	const getTables = () => {
		fetch(API_URL + "/teams")
			.then((res) => res.json())
			.then(res => {
				res = res.sort((a, b) => {
					if (a.stats.pts < b.stats.pts) return 1;
					if (a.stats.pts === b.stats.pts) {
						if (a.stats.goals_diff < b.stats.goals_diff) return 1;
						else return -1;
					} else return -1;
				});
				setTeams(res);
			});
	}

	const organizeMatches = () => {
		let weekTime = parseInt(window.prompt('How many weeks should organize?'));
		fetch(API_URL + "/organizeMatches/"+weekTime)
			.then(res => res.json())
			.then(res => res.success ? getTables() : null)
	}
	return (
		<div className="row justify-content-center vh-100 mt-2">
			<div className="col-md-12 d-flex flex-column justify-content-center overflow-auto">
				<div className="table-header d-flex align-items-center justify-content-between my-2 mx-2">
					<h3 className="mb-0">League Table</h3>
					<button
						className="btn btn-secondary"
						onClick={() => organizeMatches()}>Organize Matches
					</button>
				</div>
				<table className="table text-center">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th
								scope="col"
								className="text-left">Teams
							</th>
							<th scope="col">Pts</th>
							<th scope="col">Played</th>
							<th scope="col">Won</th>
							<th scope="col">Drawn</th>
							<th scope="col">Lose</th>
							<th scope="col">Goals Diff</th>
							<th scope="col">Predict</th>
						</tr>
					</thead>
					<tbody>
						{teams.map((team, teamIndex) => (
							<tr key={teamIndex}>
								<th scope="row">{teamIndex + 1}</th>
								<td className="text-left">{team.name}</td>
								<td>{team.stats.pts}</td>
								<td>{team.stats.played}</td>
								<td>{team.stats.won}</td>
								<td>{team.stats.drawn}</td>
								<td>{team.stats.lose}</td>
								<td>{team.stats.goals_diff}</td>
								<td>{((team.stats.won - team.stats.lose) / (100 / team.stats.pts)).toFixed(2)} %</td>
							</tr>
						))}
					</tbody>
				</table>
			</div>
		</div>
	);
}

export default Table;
