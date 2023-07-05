# d3FrameworkBundle


Add the content of the extra block to your composer.json to use our recipe:
```json
{
  "extra": {
    "symfony": {
      "endpoint": [
        "https://api.github.com/repos/LionAndDeer/recipes/contents/index.json?ref=main",
        "flex://defaults"
      ]
    }
  }
}
```