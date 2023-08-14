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
**<ins>Go Rure</ins>** | 2.61 | 2.11 | 3.33 | 8.05
**C++ SRELL** | 1.74 | 3.03 | 10.67 | 15.45
**Rust** | 11.95 | 0.96 | 3.05 | 15.96
**Nim** | 13.98 | 14.35 | 3.13 | 31.46
**PHP** | 14.43 | 14.63 | 4.87 | 33.93
**<ins>Go PCRE</ins>** | 14.18 | 14.98 | 6.21 | 35.37
**C# .Net Core** | 10.83 | 5.10 | 26.71 | 42.64
**Nim Regex** | 1.91 | 42.07 | 8.47 | 52.46
**Crystal** | 25.04 | 25.29 | 5.41 | 55.73
**Javascript** | 42.78 | 30.17 | 0.92 | 73.87
**<ins>Go Re2</ins>** | 35.81 | 37.86 | 33.79 | 107.46
**C++ Boost** | 47.05 | 46.90 | 15.68 | 109.62
**Julia** | 67.24 | 58.62 | 4.31 | 130.17
**<ins>Go Hyperscan</ins>** | 90.17 | 31.64 | 8.68 | 130.49
**Perl** | 92.51 | 66.42 | 22.51 | 181.44
**Dart** | 73.48 | 63.60 | 80.52 | 217.59
**C PCRE2** | 109.73 | 101.05 | 10.95 | 221.72
**D ldc** | 198.96 | 203.63 | 4.81 | 407.40
**D dmd** | 243.64 | 247.04 | 5.18 | 495.85
**Python PyPy2** | 159.73 | 150.25 | 255.97 | 565.95
**Kotlin** | 120.31 | 163.53 | 293.69 | 577.53
**Python PyPy3** | 226.90 | 209.65 | 238.85 | 675.39
**Java** | 205.14 | 201.55 | 295.68 | 702.36
**C++ STL** | 328.87 | 273.43 | 230.35 | 832.64
**<ins>Go</ins>** | 270.19 | 275.73 | 504.79 | 1050.71
**<ins>Go Regexp2</ins>** | 1703.51 | 1482.60 | 64.46 | 3250.57
**C# Mono** | 2543.82 | 2139.44 | 110.37 | 4793.64

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
