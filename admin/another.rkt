#lang racket
;; Syntakticky analyzator za pomoci rekurzivniho sestupu
;;
;; Gramatika LR
;; S -> S+A | S - A
;; S -> A
;; A -> A*B | A/B
;; A -> B
;; B -> n | (S)
;;
;; Gramatika LL1 
;; S -> AB
;; B -> +AB | -AB | eps
;; A -> CD
;; D -> *CD | /CD | eps
;; C -> n | (S)

;; Tabulka pro LL gramatiku
;; Analyticka?? tabulka s vystupem
;;
;;      *      +      -      /      (      )      n      $
;;  S                               AB            AB
;;  A                               CD            CD
;;  B          +AB    -AB                  eps           eps
;;  C                               (S)           n
;;  D   *CD    eps    eps   /CD            eps           eps


;; Prekladova gramatika na postfix
;; vystup je v ''
;; S -> AB
;; B -> +A'+'B | -A'-'B | eps
;; A -> CD
;; D -> *C'*'D | /C'/'D | eps
;; C -> n'n' | (S)

;; Prekladova LL1 gramatika na postfix
;; Prekladova tabulka s vystupem
;; vystup je v ''
;;      *      +      -      /      (      )      n      $
;;  S                               AB            AB
;;  A                               CD            CD
;;  B          +A'+'B -A'-'B               eps           eps
;;  C                               (S)           n'n'
;;  D   *C'*'D eps    eps   /C'/'D         eps           eps


;; omezeni jsou zatim, ze cislo muze byt pouze jeden znak  0-9,
;; vstupni vyraz se zadava jako string a musi byt bez mezer
;; poznamka cviciciho - kdyz budete delat neco podobneho jako semestralku, tak odstrante tyto omezeni


;globalni promenne pro vstup a vystup
(define vstup '())
(define vystup '())


;otestuje, zda je znak ocekavany, kdyz me chyba, jinak odebere tento znak ze vstupu
(define (expect znak)
  (if (equal? (cti) znak)
      (set! vstup (cdr vstup))
      (error "Ocekavano " znak " na vstupu " (car vstup))))

;precte dalsi znak
(define (cti)
  (if (empty? vstup)
      (error "Chyba cteni")
      (car vstup)))

;ulozi znak do vystupu
(define (naVystup znak)
  (set! vystup (append vystup (list znak))))

;S -> AB
(define (neterminalS)
  (begin
    (neterminalA)
    (neterminalB)))

;A -> CD
(define (neterminalA)
  (begin
    (neterminalC)
    (neterminalD)))

;B -> +AB | -AB | eps
(define (neterminalB)
  (if (empty? vstup)
      (void)
      (case (cti)
        ((#\+) (begin
                 (expect #\+)
                 (neterminalA)
                 (naVystup #\+)
                 (neterminalB)
                 ))
        ((#\-) (begin
                 (expect #\-)
                 (neterminalA)
                 (naVystup #\-)
                 (neterminalB)
                 ))
        ((#\)) (void))
        (else (error "Ocekavano + - )")))))

;C -> n | (S)
(define (neterminalC)
  (if (char-numeric? (cti))
      (begin
        (naVystup (cti))
        (expect (cti)))
      (case (cti)
        ((#\() (begin
                 (expect #\()
                 (neterminalS)
                 (expect #\))))
        (else
         (error "Ocekavana ( nebo n")))))


;D -> *CD | /CD | eps
(define (neterminalD)
  (if (empty? vstup)
      (void) ;nedelej nic
      (case (cti)
        ((#\*) (begin
                 (expect #\*)
                 (neterminalC)
                 (naVystup #\*)
                 (neterminalD)
                 ))
        ((#\+ #\- #\)) (void))
        ((#\/) (begin
                 (expect #\/)
                 (neterminalC)
                 (naVystup #\/)
                 (neterminalD)
                 ))
        (else (error "Ocekavano * + - / )")))))


;spusti syntaktickou analyzu vyrazu
(define (analyzator aString)
  (set! vstup (string->list aString))
  (neterminalS)
  (if (empty? vstup)
      #t
      (error "Ocekavan prazdny vstup" vstup)))

; analyzator s odchycenim vyjimky
(define (analyzatorE aString)
  (with-handlers ((exn:fail? (lambda (exn) #f)))
    (analyzator aString)))

;prevede infixovy vyraz na postfixovy
(define (infix->postfix stringVyraz)
  (set! vystup '())
  (if (analyzatorE stringVyraz)
      (list->string vystup)
      (error "Chyba")))

(analyzator "(1+1)")
(analyzatorE "(1+1")
(analyzatorE "(1+1))")
(infix->postfix "(1+1)")
(infix->postfix "((2*3)/3+1)")
(infix->postfix "((2*3)/3+1+4)")
(infix->postfix "(1+2-3+4)")
(infix->postfix "((1+2)-3+4)")

;;Testy
(equal? (analyzator "1+1") #t)
(equal? (analyzatorE "(1+1") #f)
(equal? (analyzatorE "(1+1))") #f)
(equal? (infix->postfix "(1+2-3+4)") "12+3-4+")
(equal? (infix->postfix "((2*3)/3+1+4)") "23*3/1+4+")
