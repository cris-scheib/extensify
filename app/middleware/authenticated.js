export default function ( context ) {
  if(context.$auth.$storage === null && context.$auth.$storage === undefined){
    return redirect('/login')
  }
  if(context.$auth.$storage.getUniversal('token') === null && 
  context.$auth.$storage.getUniversal('token') === undefined){
    return redirect('/login')
  }
  
}