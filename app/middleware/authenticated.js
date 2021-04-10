export default function(context) {
  const { redirect, auth, storage } = context;
  if (context.$auth.$storage === null || context.$auth.$storage === undefined) {
    return redirect("/unauthorized");
  }
  if (
    context.$auth.$storage.getUniversal("name") === null ||
    context.$auth.$storage.getUniversal("name") === undefined
  ) {
    return redirect("/unauthorized");
  }
}
