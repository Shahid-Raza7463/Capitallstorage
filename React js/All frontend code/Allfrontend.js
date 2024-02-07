
//*
//*
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
