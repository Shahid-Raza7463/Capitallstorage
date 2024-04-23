//*
//Start hare
//Start hare
//*
//Start hare
//Start hare
//*
//Start hare
//Start hare
//*
//Start hare
//Start hare
//*
//Start hare
//Start hare
//*
//Start hare
//Start hare
//*
//Start hare
//Start hare
//*
//Start hare
//Start hare
//*
//Start hare
//Start hare
//* regarding database / regarding join / regarding table 
//Start hare

app.get('/networks', (req, res) => {
    const query = `
        SELECT 
            n.network_id, n.network_name, n.network_type, n.network_url, 
            n.network_description, n.offer_count, n.min_payout, n.referral_commission, 
            n.affiliate_tracking_software, n.logo, n.review_count, n.rating, 
            n.tracking_link, n.is_sponsored, n.is_top_network, n.is_featured, 
            n.network_slug, n.status, nr.all_rating, nr.offer_rating, 
            nr.payout_rating, nr.tracking_rating, nr.support_rating, nr.review_text, 
            nr.review_img, nr.review_id, nr.created_at,
            GROUP_CONCAT(DISTINCT CONCAT(v.title, ':', v.icon)) AS verticals_titles,
            GROUP_CONCAT(DISTINCT nfl.name) AS name,
            GROUP_CONCAT(DISTINCT pl.name) AS payment_lists,
            GROUP_CONCAT(DISTINCT ct.name) AS commission_type
        FROM 
            networks AS n
        LEFT JOIN 
            network_review AS nr ON nr.network_id = n.network_id
        LEFT JOIN 
            network_verticals AS nv ON nv.network_id = n.network_id
        LEFT JOIN 
            verticals AS v ON nv.vertical_id = v.id
        LEFT JOIN 
            network_payout_frequency AS npf ON npf.network_id = n.network_id
        LEFT JOIN 
            net_frequency_lists AS nfl ON npf.payment_frequency = nfl.id
        LEFT JOIN 
            network_payment_method AS npm ON n.network_id = npm.network_id
        LEFT JOIN 
            payment_lists AS pl ON npm.payment_method = pl.id
        LEFT JOIN 
            networks_commission_type AS nct ON nct.network_id = n.network_id
        LEFT JOIN 
            commission_types AS ct ON nct.commission_type = ct.id
        GROUP BY 
            n.network_id
    `;

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});
//Start hare
app.get('/networks', (req, res) => {
    // const query = 'SELECT * FROM customers';
    const query = 'SELECT * FROM networks';

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});
//Start hare
//* backend index.js file get through chatgpt
const express = require('express');
const cors = require('cors');
const mysql = require('mysql');

const app = express();

// Enable CORS for all routes
app.use(cors({
    origin: '*',
    methods: 'GET,HEAD,PUT,PATCH,POST,DELETE',
    preflightContinue: false,
    optionsSuccessStatus: 204,
    credentials: true,
    allowedHeaders: 'Content-Type,Authorization',
}));

const con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "expertaff"
});

con.connect(function (err) {
    if (err) {
        console.error('Error connecting to database:', err);
        throw err;
    }
    console.warn("Connected!");
});

// Handle cleanup when the server exits
process.on('exit', () => {
    con.end();
    console.log('Database connection closed.');
});

// Parse JSON requests
app.use(express.json());

// Find data in node js route 5000
app.get('/', (req, res) => {
    const query = 'SELECT * FROM users';

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});

// Find data in node js route 5000
app.get('/contactus', (req, res) => {
    const query = 'SELECT * FROM contactus';

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});

app.get('/networks', (req, res) => {
    const query = 'SELECT * FROM networks';

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});

// Dynamic port binding
const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});

//* another way 
const express = require('express');
const cors = require('cors');
const mysql = require('mysql');

const app = express();

// Enable CORS for all routes
app.use(cors({
    origin: '*',
    methods: 'GET,HEAD,PUT,PATCH,POST,DELETE',
    preflightContinue: false,
    optionsSuccessStatus: 204,
    credentials: true,
    allowedHeaders: 'Content-Type,Authorization',
}));

const con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    // database: "hero"
    database: "expertaff"
});

con.connect(function (err) {
    if (err) throw err;
    console.warn("Connected!");
});

// find data in node js routre 5000
app.get('/', (req, res) => {
    // const query = 'SELECT * FROM customers';
    const query = 'SELECT * FROM users';

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});

// find data in node js routre 5000
app.get('/contactus', (req, res) => {
    // const query = 'SELECT * FROM customers';
    const query = 'SELECT * FROM contactus';

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});

app.get('/networks', (req, res) => {
    // const query = 'SELECT * FROM customers';
    const query = 'SELECT * FROM networks';

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});



// const PORT = process.env.PORT || 5000;

// app.listen(PORT, () => {
//     console.log(`Server is running on port ${PORT}`);
// });

app.listen(5000);