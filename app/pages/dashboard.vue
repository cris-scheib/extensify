<template>
  <div>
    <Layout>
      <RandomChart />

    </Layout>
  </div>
</template>

<script>
export default {
  middleware: ["authenticated"],
};
</script>

