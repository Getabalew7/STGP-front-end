#lang racket

;; author: Hailemariam Getabalew Amtate
;; Email:  xhaig001@studenti.czu.cz

;; LR Grammer ;; Eventhough the grammer has a left recursion
;; E -> E + T
;; E -> T
;; T -> F * T
;; T -> F
;; F -> num | (E)
;;
;; LL1 Grammer after removing left recursion
; E -> T B
; B -> + T B | eps
; T -> F C
; C -> * F C | eps
; F -> ( E ) | num


;;First and Follow of each non terminals
; First(E) = {(, num}                   Follow(E) = {$, +, *}
; First(T) = First(F) = {(, num}        Follow(T) = {+, *, $}
; First(B) = {+, ε}                     Follow(B) = {+, *, $}
; First(C) = {*, ε}                     Follow(C) = {+, *, $}
; First(F) = {(, num}                   Follow(F) = {+, *, $}

;; Table for LL1 grammer
;;  		num		+	    *	    (	    )	    $
;;  E		TB                TB
;;  B				  +TB				        eps   eps
;;  T		FC								FC
;;  C					eps		*FC         eps   eps
;;  F		num		            (E)


; Define global variables for input and output
(define input '())
(define output '())

; Function to check if the character matches the expected character
(define (expect znak)
  (if (equal? (cti) znak) (set! input (cdr input)) (error "Expected " znak " in input " (car input))))

; Function to read the next character from the input
(define (cti)
  (if (empty? input) (error "Error reading") (car input)))

; Function to append a character to the output
(define (naoutput znak)
  (set! output (append output (list znak))))

; Function to parse non-terminal E
(define (neterminalE)
  (begin
    (neterminalT)
    (neterminalB)))

; Function to parse non-terminal B
(define (neterminalB)
  (if (empty? input)
      (void)
      (case (cti)
        [(#\+)
         (begin
           (expect #\+)
           (neterminalT)
           (naoutput #\+)
           (neterminalB))]
        [else (void)])))

; Function to parse non-terminal T
(define (neterminalT)
  (begin
    (neterminalF)
    (neterminalC)))

; Function to parse non-terminal C
(define (neterminalC)
  (if (empty? input)
      (void)
      (case (cti)
        [(#\*)
         (begin
           (expect #\*)
           (neterminalF)
           (naoutput #\*)
           (neterminalC))]
        [else (void)])))

; Function to parse non-terminal F
(define (neterminalF)
  (case (cti)
    [(#\()
     (begin
       (expect #\()
       (neterminalE)
       (expect #\)))]
    [(#\0 #\1 #\2 #\3 #\4 #\5 #\6 #\7 #\8 #\9)
     (begin
       (naoutput (cti))
       (expect (cti)))]
    [else (error "Expected '(' or 'num'")]))

; Function to start the syntactic analysis of the expression
(define (analyzator aString)
  (set! input (string->list aString))
  (neterminalE)
  (if (empty? input) #t #f))

; Function to analyze the expression with error handling
(define (analyzatorE aString)
  (with-handlers ([exn:fail? (lambda (exn) #f)])
    (analyzator aString)))

; Test cases
(analyzatorE "(1+2)*3") ; Supported
(analyzatorE "(1+2)-3") ; Supported
(analyzatorE "1+2*3") ; Supported
(analyzatorE "((1+2)*3") ; UnSupported
(analyzatorE "1+2)*3") ; UnSupported
(analyzatorE "(1+2)*3") ; Supported
(analyzatorE "1+2*3") ; Supported
(analyzatorE "((1+2)*3") ; Unsupported (missing closing parenthesis)
(analyzatorE "1+2)*3") ; Unsupported (extra closing parenthesis)
(analyzatorE "1+") ; Unsupported (incomplete expression)
(analyzatorE "*(1+2)") ; Unsupported (operator without operands)
(analyzatorE "(1+2)") ; Supported
(analyzatorE "((1+2)+3)") ; Supported
