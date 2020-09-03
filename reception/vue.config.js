module.exports = {
  // output built static files to Laravel's public dir.
  // note the "build" script in package.json needs to be modified as well.
  outputDir: "../public/reception",

  // modify the location of the generated HTML file.
  // make sure to do this only in production.
  indexPath: "../../resources/views/reception.blade.php",

  publicPath: "/reception"
};