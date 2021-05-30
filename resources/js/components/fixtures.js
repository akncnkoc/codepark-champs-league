import React, {useEffect, useState} from "react";

function Fixtures() {
	const API_URL = "http://127.0.0.1:8000/api/v1";
	const [fixtures, setFixtures] = useState([]);

	useEffect(() => {
		fetch(API_URL + "/getFixtures")
			.then(res => res.json())
			.then(res => {
				setFixtures(res);
			})
	}, []);
	return (
		<div className="row justify-content-center vh-100 mt-2">
			<div className="col-md-12 overflow-auto">
				<div className="table-header d-flex align-items-center justify-content-between my-2 mx-2">
					<h3 className="mb-0">Fixtures</h3>
				</div>
				<div className="row">
					{Object.keys(fixtures).map((week, index) => (
						<div
							className="card col-md-6"
							key={index}>
							<div className="card-body text-center">
								<h3>{week} . Week</h3>
								<table className="text-center w-100">
									<tbody>
										{fixtures[week].map((item, i) => (
											<tr key={i * 12}>
												<td> {item.host_team.name} </td>
												<td>
													<b>{item.host_goal}</b>
													- <b>{item.away_goal}</b></td>
												<td> {item.away_team.name}</td>
											</tr>
										))}
									</tbody>
								</table>
							</div>
						</div>
					))}
				</div>

			</div>
		</div>
	);
}

export default Fixtures;
