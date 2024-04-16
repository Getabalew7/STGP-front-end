#lang racket
;;
;; author: Hailemariam Getabalew Amtate
;; Email xhaig001@studenti.czu.cz

;;;;;Algorithm

; If the current element is a number, push it onto the stack.
; If the current element is an operator, pop two operands from the stack, apply the operator to them, and push the result back onto the stack.
; If the current element is an opening parenthesis, push it onto the stack.
; If the current element is a closing parenthesis, pop elements from the stack and add them to the infix expression until the corresponding opening parenthesis is found.

; Define a function to check if a symbol is an arithmetic operator
(define (is-operator? x)
  (or (equal? x '+) (equal? x '-) (equal? x '*) (equal? x '/)))

; Define a function to apply an operator to two operands i.e. string concatination
(define (apply-operator op arg1 arg2)
  (string-append "(" arg1 " " (symbol->string op) " " arg2 ")"))

; Define a helper function to recursively convert a postfix expression to infix
(define (post->inf-helper stack expr)
  (cond
    ; If the expression is empty, return the top of the stack
    [(null? expr) (car stack)]
    ; If the current element is a number, push it onto the stack
    [(number? (car expr)) (post->inf-helper (cons (number->string (car expr)) stack) (cdr expr))]
    ; If the current element is an operator, pop two operands and apply the operator
    [(is-operator? (car expr))
     (let ([operand2 (car stack)] [operand1 (cadr stack)])
       (post->inf-helper (cons (apply-operator (car expr) operand1 operand2) (cddr stack))
                         (cdr expr)))]
    ; If the current element is invalid, throw an error
    [else (error "Invalid expression")]))

; Define the main function to convert a postfix expression to infix
(define (post->inf expr)
  (post->inf-helper '() expr))

; Test cases
(displayln (post->inf '(1 2 + 3 *))) ; Expected output: ((1 + 2) * 3)
(displayln (post->inf '(1 2 +))) ; Expected output: (1 + 2)
(displayln (post->inf '(4 5 *))) ; Expected output: (4 * 5)
(displayln (post->inf '(10 3 /))) ; Expected output: (10 / 3)
(displayln (post->inf '(2 3 4 + *))) ; Expected output: (2 * (3 + 4))
(displayln (post->inf '(5 6 + 7 *))) ; Expected output: ((5 + 6) * 7)
(displayln (post->inf '(8 2 / 3 *))) ; Expected output: ((8 / 2) * 3)

