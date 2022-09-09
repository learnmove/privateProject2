

 const Auth={}
 Auth.install=function (Vue, options) {
     Vue.prototype.$auth=Vue.auth= {
      setAuth(token,user){
        this.setToken(token)
        this.setUser(user)
      },
      setToken(token){
          localStorage.setItem('token','Bearer '+token)
          
      },
       setUser(user){
          localStorage.setItem('user',JSON.stringify(user))
          
      },
       setSchoolId(id){
          var user = JSON.parse(localStorage.getItem('user'))
          user.school_id = id;
          localStorage.setItem('user',JSON.stringify(user))
          
      },
      getToken(){
       return localStorage.getItem('token')
      },
      getUser(){
          if(localStorage.getItem('user')){
         return JSON.parse(localStorage.getItem('user'))
            
          }
        return false
      },
         getUserSchoolId(){
          if(localStorage.getItem('user')){
         return JSON.parse(localStorage.getItem('user')).school_id
            
          }
        return false
      },
        getUserId(){
          if(localStorage.getItem('user')){
         return JSON.parse(localStorage.getItem('user')).id
            
          }
        return false
      },
      isAuthenticate(){
          if(this.getToken()){
              return true
          }else{
              return false
          }
      },
      destroyLogin(){
          localStorage.removeItem('token')
          localStorage.removeItem('user')
      }

  }
   
}
 export default  Auth