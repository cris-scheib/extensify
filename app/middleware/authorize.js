const querystring = require('querystring');

export default function ({redirect, route}) {

  if(route.query.code === undefined){
    let state = '';
    let possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    for (let i = 0; i < 16; i++) {
      state += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    
       redirect("https://accounts.spotify.com/authorize?" + 
             querystring.stringify({
           response_type: 'code',
           client_id: process.env.CLIENT_ID,
           scope: process.env.SCOPE,
           redirect_uri: process.env.REDIRECT_URI,
           state: state
      }))
  }
}