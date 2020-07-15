
  const DARKSKY_API_KEY = process.env.DARKSKY_API_KEY
  const axios = require('axios')
  const express = require('express')
  const app = express()
  
  app.use(express.json())
  app.use(express.static('public'))
  
  app.post('/weather', (req, res) => {
    const url = `https://api.darksky.net/forecast/444e72390dedff6ef44c8fb8d6c848db/${req.body.latitude},${req.body.longitude}?units=auto`
    axios({
      url: url,
      responseType: 'json'
    }).then(data => res.json(data.data.currently))
  })
  

