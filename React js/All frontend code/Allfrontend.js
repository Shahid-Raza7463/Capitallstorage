
//*
//*
// Start hare 
// Start hare 
//*
// Start hare 
// Start hare 
//*
// Start hare 
// Start hare 
//*
// Start hare 
// Start hare 
//*
// Start hare 
// Start hare 
//* regarding ratings
// Start hare 
// Assuming these calculations are done before rendering the JSX
const ratings = item.rating; // Replace with your rating value
const maxRating = 5; // Maximum rating value

const filledStars = Math.floor(ratings);
const hasHalfStar = ratings - filledStars >= 0.5;
const emptyStars = maxRating - filledStars - (hasHalfStar ? 1 : 0);

// Then use these variables in your JSX
<div className="mt-2 mx-3">
    <span className="badge join-badge">{item.rating}</span>
    <div className="table-rating d-flex">
        {/* Render Empty stars */}
        {[...Array(emptyStars)].map((_, index) => (
            <i key={index} className="fas fa-3x fa-star icon-color"></i>
        ))}
        {/* Render Half-star if present */}
        {hasHalfStar && <i className="fas fa-3x fa-star-half-alt"></i>}
        {/* Render Filled stars */}
        {[...Array(filledStars)].map((_, index) => (
            <i key={index} className="fas fa-3x fa-star"></i>
        ))}
    </div>
</div>

// Start hare 
//* regarding data display

// Start hare 
import React from 'react';

// TableRow component
const TableRow = ({ network }) => {
    return (
        <div className="d-flex justify-content-between">
            {/* Render network logo */}
            <img src={network.logo} className="img-fluid network-img rounded" />

            {/* Render network name and badge */}
            <div className="mx-4 mobile-div">
                <h6 className="prm-net">
                    <a href={network.network_url} className="text-dark">{network.network_name}</a>
                    {network.is_sponsored === 1 && (
                        <span className="badge spon-badge mx-1">Sponsored</span>
                    )}
                </h6>

                {/* Render icons */}
                <div className="table-icon">
                    {/* Render icons here */}
                </div>

                {/* Render text */}
                <div className="table-text mt-2">
                    <p>{network.review_count} Reviews / {network.affiliate_tracking_software} / {network.name}</p>
                </div>
            </div>

            {/* Render description */}
            <div className="desc-td">
                <p className="description mt-2">{network.network_description}</p>
            </div>

            {/* Render offer count */}
            <div className="m-offer">
                <p className="fw-bold off-text">{network.offer_count}</p>
            </div>

            {/* Render Join button */}
            <div className="m-td">
                <button type="button" className="btn table-btn mx-3" fdprocessedid="6sljwl">Join Now</button>
                <div className="mt-2 mx-3">
                    {/* Render rating component */}
                </div>
            </div>
        </div>
    );
};

// Container component
class NetworkTable extends React.Component {
    render() {
        const { networksData } = this.props;
        return (
            <div className="container mt-4">
                <div className="table-div">
                    <div className="d-flex justify-content-between head-div">
                        {/* Render table headers */}
                    </div>
                    {/* Render table rows */}
                    {networksData.map((network, index) => (
                        <TableRow key={index} network={network} />
                    ))}
                </div>
            </div>
        );
    }
}

export default NetworkTable;

// Start hare 
//*navbar / nav bar 
import React from 'react';
import { Link } from 'react-router-dom';

const NavBar = ({ setCurrentPage }) => {
    return (
        <nav>
            <ul>
                <li>
                    <Link to="/" onClick={() => setCurrentPage('home')}>
                        Home
                    </Link>
                </li>
                <li>
                    <Link to="/about" onClick={() => setCurrentPage('about')}>
                        About
                    </Link>
                </li>
                <li>
                    <Link to="/contact" onClick={() => setCurrentPage('contact')}>
                        Contact Us
                    </Link>
                </li>
            </ul>
        </nav>
    );
};

export default NavBar;

// import React from 'react';
import React, { useState, useEffect } from 'react';
import axios from 'axios';

const About = () => {


    const [data, setData] = useState([]);

    useEffect(() => {
        // call fetchData function 
        fetchData();
    }, []);


    // Get data on react app from nodejs route 5000
    const fetchData = async () => {
        try {
            const response = await axios.get('http://localhost:5000/contactus');
            setData(response.data);
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    };
    return (
        // <div>
        //   <h2>About Page</h2>
        //   <p>Learn more about us on the About Page.</p>
        // </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>email</th>
                    </tr>
                </thead>
                <tbody>
                    {data.map((item, index) => (
                        <tr key={index}>
                            <td>{item.id}</td>
                            <td>{item.name}</td>
                            <td>{item.email}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default About;

//*app.js 
import React, { useState } from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

import Home from './components/Home';
import About from './components/About';
import Contact from './components/Contact';
import NavBar from './components/navbar/NavBar';
import './App.css';

const App = () => {
    const [currentPage, setCurrentPage] = useState('home');

    return (
        <Router>
            <div>
                <NavBar setCurrentPage={setCurrentPage} />
                <hr />

                <Routes>
                    <Route path="/" element={<Home />} />
                    <Route path="/about" element={<About />} />
                    <Route path="/contact" element={<Contact />} />
                </Routes>
            </div>
        </Router>
    );
};

export default App;

//* data display from multiple table in one page 

import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Contact = () => {
    const [networksData, setNetworksData] = useState([]);
    const [contactusData, setContactusData] = useState([]);
    const [usersData, setUsersData] = useState([]);

    useEffect(() => {
        // Call fetchData function for networks
        fetchData('http://localhost:5000/networks', setNetworksData);

        // Call fetchData function for contactus
        fetchData('http://localhost:5000/contactus', setContactusData);

        // Call fetchData function for users
        fetchData('http://localhost:5000/', setUsersData);
    }, []);

    const fetchData = async (url, setDataFunction) => {
        try {
            const response = await axios.get(url);
            setDataFunction(response.data);
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    };

    return (
        <div>
            <h2>Data from Networks Table</h2>
            <p>Feel free to reach out to us!</p>

            <table>
                <thead>
                    <tr>
                        <th>network_id</th>
                        <th>network_name</th>
                        <th>network_url</th>
                    </tr>
                </thead>
                <tbody>
                    {networksData.map((item, index) => (
                        <tr key={index}>
                            <td>{item.network_id}</td>
                            <td>{item.network_name}</td>
                            <td>{item.network_url}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
            <h2>Data from contactus Table</h2>
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>email</th>
                    </tr>
                </thead>
                <tbody>
                    {contactusData.map((item, index) => (
                        <tr key={index}>
                            <td>{item.id}</td>
                            <td>{item.name}</td>
                            <td>{item.email}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
            <h2>Data from users Table</h2>
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>email</th>
                    </tr>
                </thead>
                <tbody>
                    {usersData.slice(0, 10).map((item, index) => (
                        <tr key={index}>
                            <td>{item.id}</td>
                            <td>{item.name}</td>
                            <td>{item.email}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default Contact;

//* regarding data display / 
<table>
    <thead>
        <tr>
            <th>id</th>
            <th>Name</th>
            <th>email</th>
        </tr>
    </thead>
    <tbody>
        {usersData.slice(0, 10).map((item, index) => (
            <tr key={index}>
                <td>{item.id}</td>
                <td>{item.name}</td>
                <td>{item.email}</td>
            </tr>
        ))}
    </tbody>
</table>
//* display data from database on react app
// import React from 'react';
import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Home = () => {

    const [data, setData] = useState([]);

    useEffect(() => {
        // call fetchData function 
        fetchData();
    }, []);


    // Get data on react app from nodejs route 5000
    const fetchData = async () => {
        try {
            const response = await axios.get('http://localhost:5000/');
            setData(response.data);
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    };




    return (
        // <div>
        //   <h2>Home Page</h2>
        //   <p>Welcome to the Home Page!</p>
        // </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    {data.map((item, index) => (
                        <tr key={index}>
                            <td>{item.name}</td>
                            <td>{item.address}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default Home;
