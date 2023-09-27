const fs = require('fs');
const path = require('path');
const sourceFileName = "index.html";
const destFileName = "admin.php";
const sourcePath = "../../public/admin/"
const destPath = "../views"
const sourceFile = path.join(__dirname, sourcePath, sourceFileName);
const destFile = path.join(__dirname, destPath, destFileName);
fs.rename(sourceFile, destFile, function (err) {
  if (err) throw err;
  fs.stat(destPath, function (err, stats) {
    if (err) throw err;
    console.log('stats: ' + JSON.stringify(stats));
  });
});

