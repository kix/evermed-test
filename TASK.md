# Backend Developer Coding Test: Download Library Task Overview
We need you to create a production-ready library that downloads public files from various cloud storage providers 
(Google Drive, OneDrive) and regular public URLs.

The library should be designed with extensibility in mind to support future providers like Dropbox, Box, etc.

## Requirements
Core Functionality
- Download public files from:
  - Google Drive public links
  - OneDrive public links
  - Direct HTTP/HTTPS URLs
- Return `Symfony\Component\HttpFoundation\File\UploadedFile` for downloaded files
- Handle different URL formats and edge cases gracefully

We are providing you with a `composer.json` initial content that already includes several libraries which could 
potentially be useful for development. The purpose of sharing this content is to give you a starting point with some 
common dependencies, but it is entirely up to you to decide whether any of them will help you in your implementation. 
You are also free to add your own libraries, if you feel they are necessary for the integration you have in mind.
  
To summarize:
- The provided composer.json contains pre-selected libraries you may find useful.
- You can choose whether to use them.
- You are free to add additional dependencies if they support your solution.
- The goal is for you to evaluate and decide what best fits your approach.

### Architecture & Design
- Extensible design: Easy to add new providers in the future
- Clean separation of concerns: Each provider should be independent
- Error handling: Proper exception hierarchy and meaningful error messages
- SOLID principles: Follow good OOP practices

# Approach

## Phase 1: Architecture & Structure (Start Here)
1. Define your architecture: How will you organize the code? What patterns will you use?
2. Implement with pseudo-code: Focus on structure, not implementation details
3. Plan for extensibility: How will new providers be added?

## Phase 2: Implementation
1. Implement the actual download logic for each provider
2. Handle HTTP requests, response parsing, file streaming
3. Add proper error handling and validation
   
# What We're Looking For
## Technical Skills
- Code organization: Clear structure and logical separation
- Design: What architecture will you choose?
- Extensibility: How easy would it be to add e.g. Dropbox support?
- Error handling: You should use some error handling.
## Problem-Solving Approach
- Analysis: How do you break down the problem?
- Decision-making: Why did you choose specific patterns/approaches, if so?
- Trade-offs: What compromises did you make and why?

## Guidelines on AI Usage
The use of AI tools is permitted and encouraged as part of the problem-solving process.

Candidates are, however, expected to demonstrate a clear understanding of the submitted solution. This includes being 
able to explain the reasoning behind the chosen approach, justify design decisions, and take full responsibility for 
the correctness and quality of the code.

# Submission Guidelines
## Code Delivery
- Provide complete source code with clear directory structure
- Include basic documentation (README with usage examples)
- Add comments where the logic isn't immediately obvious

## Explanation Document
Please provide a detailed explanation covering:

1. Architecture Overview
   - Why did you choose this structure?
   - What design patterns did you use and why?
   - How does your solution support future extensibility?
2. Implementation Details
   - How do you handle different URL formats?
   - What's your approach to error handling?
3. Future Considerations
   - How would you add support for Dropbox?
   - What would you improve given more time?
   - How would you handle authentication for private files?

## Hints & Guidelines
- Consider how different cloud providers structure their public URLs
- Remember that this is a library, not an application 

## Time Expectation
This task is designed to be completed in 1-2 days if possible. Pease focus on demonstrating your architectural thinking 
and problem-solving approach rather than perfecting every implementation detail.
  
## Questions?
If you have questions about requirements or need clarification, please don't hesitate to ask. We value clear communication as much as technical skills.

Good luck!
🚀