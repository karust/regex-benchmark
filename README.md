# Languages Regex Benchmark

It's just a simple regex benchmark for different programming languages.

Measures how long it takes to find and count non-overlapping occurrences with **default settings**.

> All benchmarks are wrong, but some are useful - [Szilard](https://github.com/szilard), [benchm-ml](https://github.com/szilard/benchm-ml)

I hope this benchmark can be helpful, but it's not only about performance, but each language also has its engine and offers different features (like UTF support, backreferences, capturing groups ...)

## Input text

The [input text](input-text.txt) is a concatenation of [Learn X in Y minutes](https://github.com/adambard/learnxinyminutes-docs) repository.

*Maybe isn't the best representative text. I'm searching other texts to add to the benchmark.*

## Regex patterns

- Email: ``[\w\.+-]+@[\w\.-]+\.[\w\.-]+``
- URI: ``[\w]+://[^/\s?#]+[^\s?#]+(?:\?[^\s#]*)?(?:#[^\s]*)?``
- IPv4: ``(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9])\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9])``

The above regex patterns aren't the best or the optimal. The focus is the benchmark, not the matching.

The patterns are applied to the whole file.

## Measure

Measuring is done inside the programs to avoid include startup, reading and writing times on results.

Elapsed time include pattern compilation, find and count occurrences.

## Performance

Docker image was run on: **OS**: Windows 11 + Docker v24.0.2, **CPU**: AMD Ryzen 7 5800X, **RAM**: 32GB DDR4

Language | Email(ms) | URI(ms) | IP(ms) | Total(ms)
--- | ---: | ---: | ---: | ---:
**<ins>Go Rure</ins>** | 2.59 | 1.86 | 3.07 | 7.52
**Rust** | 11.06 | 0.94 | 3.02 | 15.02
**C++ SRELL** | 1.68 | 3.01 | 10.58 | 15.27
**Nim** | 14.00 | 14.67 | 3.04 | 31.72
**PHP** | 13.78 | 13.94 | 4.36 | 32.08
**<ins>Go PCRE</ins>** | 14.16 | 15.27 | 6.53 | 35.96
**Nim Regex** | 2.04 | 43.06 | 8.65 | 53.76
**Javascript** | 43.78 | 30.73 | 0.96 | 75.47
**<ins>Go Re2</ins>** | 33.12 | 38.01 | 32.44 | 103.57
**C++ Boost** | 45.90 | 46.14 | 15.25 | 107.30
**Julia** | 66.52 | 58.43 | 4.32 | 129.26
**Crystal** | 79.76 | 71.15 | 8.69 | 159.60
**Perl** | 95.19 | 70.39 | 22.04 | 187.63
**C PCRE2** | 99.11 | 91.89 | 10.93 | 201.94
**Dart** | 70.38 | 65.27 | 78.68 | 214.33
**D ldc** | 200.27 | 202.19 | 4.87 | 407.33
**Ruby** | 224.60 | 199.09 | 35.84 | 459.53
**D dmd** | 240.58 | 245.38 | 5.26 | 491.21
**Python PyPy2** | 158.18 | 148.27 | 255.19 | 561.64
**Kotlin** | 143.98 | 163.32 | 294.68 | 601.98
**Python PyPy3** | 225.10 | 208.33 | 237.80 | 671.23
**Java** | 217.28 | 199.48 | 299.89 | 716.65
**Python 2** | 191.83 | 146.10 | 411.50 | 749.43
**Python 3** | 260.08 | 205.62 | 358.49 | 824.18
**C++ STL** | 343.71 | 283.98 | 224.88 | 852.57
**<ins>Go</ins>** | 272.62 | 276.65 | 502.79 | 1052.07
**<ins>Go Regexp2</ins>** | 1689.94 | 1475.19 | 63.85 | 3228.99
**C# Mono** | 2498.22 | 2109.05 | 110.53 | 4717.80

- **Language**: Indicates the language.
- **Email(ms)**, **URI(ms)**, **IP(ms)**: Indicates the time elapsed in milliseconds for finding and counting non-overlapping occurrences for the pattern.
- **Total(ms)**: Indicates the sum of the above times.
# How to run

The easiest way to run the benchmark is by using Docker.

```sh
git clone https://github.com/karust/regex-benchmark.git
cd regex-benchmark
docker run --rm -v $(pwd):/var/regex karust/regex-benchmark
```

# Contributing

All contributions are welcome, from tiny optimizations to new implementations.

There are only a few requirements:
- Follow the style of the current implementations
- Use the default settings for the regex engine
- Update `Dockerfile` if it's necessary

# Kudos

- Heng Li's for his work on [Benchmark of Regex Libraries](http://lh3lh3.users.sourceforge.net/reb.shtml).
- A "challenge" on [Madrid Devs](http://madriddevs.org/) group inspired me.
- [Programming subreddit](https://www.reddit.com/r/programming/), helped me to improve the benchmark.

# License

MIT © [Mario Juárez](https://github.com/mariomka).
