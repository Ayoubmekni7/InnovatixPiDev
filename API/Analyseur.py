import fitz


def analyse_cv_pdf(chemin_pdf, mots_cles):
    score = 0
    mots = []
    try:
            document = fitz.open(chemin_pdf)
            for page in document:
                texte_page = page.get_text()
                texte_page = texte_page.lower()
                for mot in mots_cles:
                    if mot.lower() in texte_page:
                        score += 1
            document.close()
    except Exception as e:
            # Gérer l'exception (erreur)
            print("Une erreur s'est produite :", e)
            return 1000
    return score
if __name__ == '__main__':
    import sys
    chemin_pdf = sys.argv[1]
    mots_cles = sys.argv[2].split(',')
    score = analyse_cv_pdf(chemin_pdf, mots_cles)
    print(score)