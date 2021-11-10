import axios from 'axios'
import { removeHeaderToken, setHeaderToken } from "../utils/auth"

export default {
    state: {
        user: null,
        isLoggedIn: false
    },
    mutations: {
        set_user (state, data) {
            state.user = data
            state.isLoggedIn = true
        },
        reset_user (state) {
            state.user = null
            state.isLoggedIn = false
        }
    },
    getters: {
        isLoggedIn (state) {
            return state.isLoggedIn
        },
        user (state) {
            return state.user
        }
    },
    actions: {
      login( { dispatch, commit }, data ) {
          return new Promise((resolve, reject) => {
              axios.post('/api/admin/login', data).then(response => {
                  const token = response.data.token
                  localStorage.setItem('token', token)
                  setHeaderToken(token)
                  resolve(response)
                  location.reload()                    
              })
              .catch(err => {
                  commit('reset_user')
                  localStorage.removeItem('token')
                  reject(err)
              })
          })
      },
      async get_user( { commit }, token ) {
          if (!localStorage.getItem('token')) {
              return
          }
          try{
              let response = await axios.get('/api/admin/find/' + token)
              commit('set_user', response.data)
          } catch (error) {
              commit('reset_user')
              removeHeaderToken()
              localStorage.removeItem('token')
              return error
          }
      },
      logout( { commit } ) {
          return new Promise((resolve) => {
              commit('reset_user')
              localStorage.removeItem('token')
              removeHeaderToken()
              resolve()
          })
      },
      register( { commit }, data ) {
          return new Promise((resolve, reject) => {
              axios.post('/api/admin/register', data).then(response => {
                  resolve(response)
              })
              .catch(err => {
                  commit('reset_user')
                  reject(err)
              })
          })
      }  
    }
}