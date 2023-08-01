package main

import (
	"bytes"
	"fmt"
	"log"
	"os"
	"time"

	regexp "github.com/BurntSushi/rure-go"
)

func measure(data []byte, pattern string) {
	start := time.Now()

	re, err := regexp.Compile(pattern)
	if err != nil {
		log.Fatal(err)
	}

	matches := re.FindAllBytes(data)

	elapsed := time.Since(start)

	// for i := 0; i < len(matches)/2; i++ {
	// 	start, end := matches[i*2], matches[i*2+1]
	// 	fmt.Println(i+1, string(data[start:end]), start, end, len(matches))
	// }

	fmt.Printf("%f - %v\n", float64(elapsed)/float64(time.Millisecond), len(matches)/2)
}

func main() {
	if len(os.Args) != 2 {
		fmt.Println("Usage: benchmark <filename>")
		os.Exit(1)
	}

	filerc, err := os.Open(os.Args[1])
	if err != nil {
		log.Fatal(err)
	}
	defer filerc.Close()

	buf := new(bytes.Buffer)
	buf.ReadFrom(filerc)
	data := buf.Bytes()

	// Email
	measure(data, `[\w\.+-]+@[\w\.-]+\.[\w\.-]+`)

	// URI
	measure(data, `[\w]+://[^/\s?#]+[^\s?#]+(?:\?[^\s#]*)?(?:#[^\s]*)?`)

	// IP
	measure(data, `(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9])\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9])`)

	// Named groups
	//measure(data, `(?P<email>[\w\.+-]+@[\w\.-]+\.[\w\.-]+)|(?P<uri>[\w]+://[^/\s?#]+[^\s?#]+(?:\?[^\s#]*)?(?:#[^\s]*)?)|(?P<ip>(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9])\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]))`)
}
