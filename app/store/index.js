
export const state = () =>
{
    auth: 'Cris'
}

export const getters = {
    getAuthenticated(state){
        return state.authenticated
    }
}
export const mutations = {
    setAuthenticated(state, data){
         state.authenticated.token = data.token;
         state.authenticated.user = data.user;
         state.authenticated.id = data.id;
         state.authenticated.image = data.image;
    }
   
}