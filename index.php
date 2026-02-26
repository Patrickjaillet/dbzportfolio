<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SAIYAN ARTS — Portfolio Légendaire</title>

<!-- Fonts DBZ-authentiques -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Black+Han+Sans&family=Noto+Serif+JP:wght@300;400;700;900&family=Sawarabi+Mincho&display=swap" rel="stylesheet">

<style>
/* ====================================================
   RESET & CSS CUSTOM PROPERTIES
   ==================================================== */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --ki-gold:      #FFD700;
  --ki-orange:    #FF8C00;
  --ki-amber:     #FFA500;
  --ki-white:     #FFFDE7;
  --blood-orange: #E65100;
  --ember:        #BF360C;
  --void:         #020408;
  --text-hero:    #FFF8E1;
  --text-sub:     #BCAAA4;
  --text-dim:     #6D4C41;
  --border-gold:  rgba(255,215,0,0.2);
  --border-hot:   rgba(255,140,0,0.35);
  --surface-dark: rgba(8, 4, 2, 0.9);
  --glow-gold:    0 0 20px rgba(255,215,0,0.4), 0 0 60px rgba(255,140,0,0.2);
  --radius:       4px;
  --radius-lg:    10px;
}

html { scroll-behavior: smooth; overflow-x: hidden; }

body {
  background: var(--void);
  color: var(--text-hero);
  font-family: 'Noto Serif JP', Georgia, serif;
  font-size: 1rem;
  line-height: 1.75;
  overflow-x: hidden;
  cursor: none;
}

/* ====================================================
   CURSEUR KI
   ==================================================== */
.cursor {
  position: fixed;
  width: 10px; height: 10px;
  border-radius: 50%;
  background: var(--ki-gold);
  pointer-events: none;
  z-index: 9999;
  transform: translate(-50%, -50%);
  box-shadow: 0 0 10px var(--ki-gold), 0 0 20px var(--ki-amber);
  mix-blend-mode: screen;
  transition: transform 0.1s ease;
}
.cursor-ring {
  position: fixed;
  width: 36px; height: 36px;
  border-radius: 50%;
  border: 1px solid rgba(255,215,0,0.5);
  pointer-events: none;
  z-index: 9998;
  transform: translate(-50%, -50%);
  transition: width 0.2s, height 0.2s, left 0.12s ease, top 0.12s ease;
}

/* ====================================================
   SHADER CANVAS
   ==================================================== */
#shader-canvas {
  position: fixed;
  inset: 0;
  z-index: 0;
  width: 100%; height: 100%;
}

.atmo-vignette {
  position: fixed;
  inset: 0;
  z-index: 1;
  pointer-events: none;
  background:
    radial-gradient(ellipse 100% 50% at 50% 0%, rgba(2,4,8,0.65) 0%, transparent 60%),
    radial-gradient(ellipse 100% 55% at 50% 100%, rgba(8,4,2,0.97) 0%, transparent 60%);
}

.speedlines {
  position: fixed;
  inset: 0;
  z-index: 2;
  pointer-events: none;
  opacity: 0;
  transition: opacity 0.5s;
  background: conic-gradient(
    from 0deg at 50% 50%,
    transparent 0deg, rgba(255,200,0,0.018) 1deg, transparent 2deg,
    transparent 8deg, rgba(255,200,0,0.012) 9deg, transparent 11deg,
    transparent 19deg, rgba(255,200,0,0.02) 20deg, transparent 22deg,
    transparent 33deg, rgba(255,200,0,0.015) 34deg, transparent 36deg,
    transparent 50deg, rgba(255,200,0,0.01) 51deg, transparent 53deg,
    transparent 68deg, rgba(255,200,0,0.018) 69deg, transparent 71deg,
    transparent 85deg, rgba(255,200,0,0.02) 86deg, transparent 88deg,
    transparent 103deg, rgba(255,200,0,0.015) 104deg, transparent 106deg,
    transparent 120deg, rgba(255,200,0,0.01) 121deg, transparent 123deg,
    transparent 140deg, rgba(255,200,0,0.018) 141deg, transparent 143deg,
    transparent 160deg, rgba(255,200,0,0.02) 161deg, transparent 163deg,
    transparent 179deg, rgba(255,200,0,0.015) 180deg, transparent 182deg,
    transparent 200deg, rgba(255,200,0,0.01) 201deg, transparent 203deg,
    transparent 220deg, rgba(255,200,0,0.018) 221deg, transparent 223deg,
    transparent 240deg, rgba(255,200,0,0.02) 241deg, transparent 243deg,
    transparent 260deg, rgba(255,200,0,0.015) 261deg, transparent 263deg,
    transparent 280deg, rgba(255,200,0,0.01) 281deg, transparent 283deg,
    transparent 300deg, rgba(255,200,0,0.018) 301deg, transparent 303deg,
    transparent 320deg, rgba(255,200,0,0.02) 321deg, transparent 323deg,
    transparent 340deg, rgba(255,200,0,0.015) 341deg, transparent 343deg,
    transparent 358deg, rgba(255,200,0,0.01) 359deg, transparent 360deg
  );
}

/* Ki particles */
.ki-particles { position: fixed; inset: 0; z-index: 3; pointer-events: none; overflow: hidden; }
.ki-particle {
  position: absolute;
  bottom: -20px;
  width: 1px;
  border-radius: 1px;
  background: linear-gradient(to top, transparent, var(--ki-gold), rgba(255,215,0,0.3));
  animation: kiRise linear infinite;
  opacity: 0;
}
@keyframes kiRise {
  0%   { opacity: 0; transform: translateY(0) scaleY(0.3); }
  8%   { opacity: 0.9; }
  80%  { opacity: 0.3; }
  100% { opacity: 0; transform: translateY(-110vh) scaleY(2); }
}

/* ====================================================
   SITE WRAPPER
   ==================================================== */
.site-wrapper { position: relative; z-index: 10; min-height: 100vh; }

/* ====================================================
   HERO
   ==================================================== */
.site-header {
  position: relative;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 40px 24px;
  overflow: hidden;
}

.hero-aura {
  position: absolute;
  inset: 0;
  pointer-events: none;
}
.hero-aura::before {
  content: '';
  position: absolute;
  left: 50%; top: 50%;
  transform: translate(-50%, -50%);
  width: 700px; height: 700px;
  border-radius: 50%;
  background: radial-gradient(circle,
    rgba(255,215,0,0.10) 0%,
    rgba(255,140,0,0.06) 35%,
    rgba(255,60,0,0.03) 60%,
    transparent 70%
  );
  animation: auraBreath 3.5s ease-in-out infinite;
}
.hero-aura::after {
  content: '';
  position: absolute;
  left: 50%; bottom: 0;
  transform: translateX(-50%);
  width: 400px; height: 600px;
  background: radial-gradient(ellipse 50% 80% at 50% 100%,
    rgba(255,100,0,0.22) 0%,
    rgba(255,200,50,0.08) 45%,
    transparent 70%
  );
  animation: auraBreath 3.5s ease-in-out infinite reverse;
}
@keyframes auraBreath {
  0%,100% { opacity: 0.5; transform: translate(-50%,-50%) scale(1); }
  50%     { opacity: 1;   transform: translate(-50%,-50%) scale(1.12); }
}

.hero-eyebrow {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(0.75rem, 2vw, 1rem);
  letter-spacing: 0.55em;
  color: var(--ki-orange);
  margin-bottom: 20px;
  opacity: 0.85;
  animation: heroFadeIn 1s ease 0.3s both;
}
@keyframes heroFadeIn {
  from { opacity: 0; transform: translateY(-15px); }
  to   { opacity: 0.85; transform: translateY(0); }
}

.hero-logo-wrap {
  position: relative;
  display: inline-block;
  animation: logoExplosion 1.4s cubic-bezier(0.16, 1, 0.3, 1) 0.5s both;
}
@keyframes logoExplosion {
  from { opacity: 0; transform: scale(0.5) translateY(60px); filter: blur(20px); }
  to   { opacity: 1; transform: scale(1) translateY(0); filter: blur(0); }
}

/* Ombre portée style manga : contour noir épais décalé */
.hero-logo-stroke {
  position: absolute;
  inset: 0;
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(4rem, 13vw, 10.5rem);
  font-weight: 400;
  line-height: 0.88;
  letter-spacing: 0.03em;
  -webkit-text-stroke: 10px rgba(0,0,0,0.85);
  color: transparent;
  transform: translate(5px, 7px);
  pointer-events: none;
  user-select: none;
}
.hero-logo {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(4rem, 13vw, 10.5rem);
  font-weight: 400;
  line-height: 0.88;
  letter-spacing: 0.03em;
  background: linear-gradient(
    168deg,
    #FFFFFF 0%,
    #FFFDE7 10%,
    #FFD700 30%,
    #FFA500 50%,
    #E65100 72%,
    #6D1E00 90%,
    #3A0E00 100%
  );
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  filter: drop-shadow(0 0 35px rgba(255,200,0,0.55)) drop-shadow(0 0 80px rgba(255,100,0,0.3));
  position: relative;
  z-index: 1;
}

.hero-subtitle {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(1rem, 3.5vw, 2rem);
  letter-spacing: 0.35em;
  color: var(--text-hero);
  opacity: 0.65;
  margin: 10px 0 36px;
  animation: heroFadeIn 1s ease 0.95s both;
}

.hero-separator {
  display: flex;
  align-items: center;
  gap: 18px;
  margin: 0 auto 44px;
  width: min(480px, 88vw);
  animation: heroFadeIn 1s ease 1.1s both;
}
.sep-line { flex: 1; height: 1px; background: linear-gradient(90deg, transparent, rgba(255,215,0,0.5)); }
.sep-line:last-child { transform: scaleX(-1); }
.sep-diamond { width: 10px; height: 10px; background: var(--ki-gold); transform: rotate(45deg); box-shadow: 0 0 16px var(--ki-gold); }

.hero-stats {
  display: flex;
  gap: 56px;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 60px;
  animation: heroFadeIn 1s ease 1.3s both;
}
.hero-stat-num {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 3rem;
  line-height: 1;
  background: linear-gradient(160deg, var(--ki-gold), var(--ki-orange));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  filter: drop-shadow(0 0 12px rgba(255,215,0,0.5));
}
.hero-stat-label {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.7rem;
  letter-spacing: 0.35em;
  color: var(--text-sub);
  text-transform: uppercase;
  margin-top: 2px;
}

.scroll-hint {
  position: absolute;
  bottom: 36px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  opacity: 0.55;
  animation: scrollBounce 2s ease-in-out infinite;
  cursor: default;
}
@keyframes scrollBounce {
  0%,100% { transform: translateX(-50%) translateY(0); }
  50%     { transform: translateX(-50%) translateY(10px); }
}
.scroll-hint span { font-family: 'Bebas Neue', sans-serif; font-size: 0.65rem; letter-spacing: 0.45em; color: var(--ki-orange); }
.scroll-chevron { width: 18px; height: 18px; border-right: 2px solid var(--ki-orange); border-bottom: 2px solid var(--ki-orange); transform: rotate(45deg); }

/* ====================================================
   NAVIGATION
   ==================================================== */
.main-nav {
  position: sticky;
  top: 0;
  z-index: 500;
  background: rgba(2, 4, 8, 0.93);
  backdrop-filter: blur(18px) saturate(1.4);
  border-bottom: 1px solid var(--border-gold);
  padding: 0 max(24px, 4vw);
  display: flex;
  align-items: center;
  justify-content: space-between;
  min-height: 58px;
}

.nav-brand {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 1.5rem;
  letter-spacing: 0.12em;
  color: var(--ki-gold);
  text-decoration: none;
  text-shadow: var(--glow-gold);
}

.nav-links { display: flex; gap: 4px; list-style: none; }
.nav-links a {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.82rem;
  letter-spacing: 0.22em;
  color: var(--text-sub);
  text-decoration: none;
  padding: 8px 16px;
  border-radius: var(--radius);
  transition: color 0.25s;
  position: relative;
}
.nav-links a::after {
  content: '';
  position: absolute;
  bottom: 3px;
  left: 16px; right: 16px;
  height: 1px;
  background: var(--ki-gold);
  box-shadow: var(--glow-gold);
  transform: scaleX(0);
  transition: transform 0.25s;
}
.nav-links a:hover, .nav-links a.active { color: var(--ki-gold); }
.nav-links a:hover::after, .nav-links a.active::after { transform: scaleX(1); }

.nav-power {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.72rem;
  letter-spacing: 0.18em;
  color: var(--ki-orange);
  border: 1px solid var(--border-hot);
  padding: 5px 16px;
  border-radius: 40px;
  text-shadow: 0 0 8px var(--ki-orange);
  animation: powerPulse 3s ease-in-out infinite;
}
@keyframes powerPulse {
  0%,100% { box-shadow: 0 0 0 rgba(255,140,0,0); }
  50%     { box-shadow: 0 0 12px rgba(255,140,0,0.3); }
}

/* ====================================================
   SECTIONS
   ==================================================== */
.section {
  position: relative;
  max-width: 1400px;
  margin: 0 auto;
  padding: 96px max(24px, 4vw);
}

.section-header { text-align: center; margin-bottom: 64px; }
.section-chapter {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.72rem; letter-spacing: 0.65em;
  color: var(--ki-orange); opacity: 0.8;
  margin-bottom: 10px;
}
.section-title {
  font-family: 'Bebas Neue', sans-serif;
  font-size: clamp(2rem, 5vw, 4rem);
  letter-spacing: 0.08em; line-height: 1;
  background: linear-gradient(155deg, var(--text-hero) 0%, var(--ki-gold) 55%, var(--ki-amber) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  filter: drop-shadow(0 0 18px rgba(255,215,0,0.2));
  margin-bottom: 10px;
}
.section-title-jp {
  font-family: 'Sawarabi Mincho', serif;
  font-size: 0.9rem;
  color: var(--text-dim);
  letter-spacing: 0.3em;
  display: block;
  margin-bottom: 24px;
}
.section-orn { display: flex; align-items: center; justify-content: center; gap: 14px; max-width: 360px; margin: 0 auto; }
.orn-line { flex: 1; height: 1px; background: var(--border-hot); }
.orn-diamond { width: 8px; height: 8px; background: var(--ki-orange); transform: rotate(45deg); box-shadow: 0 0 10px var(--ki-orange); }

/* ====================================================
   FILTERS
   ==================================================== */
.filter-bar { display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; margin-bottom: 52px; }
.filter-pill {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.78rem; letter-spacing: 0.28em;
  background: transparent;
  border: 1px solid var(--border-gold);
  color: var(--text-sub);
  padding: 9px 24px;
  border-radius: 40px; cursor: pointer;
  transition: all 0.3s ease;
  position: relative; overflow: hidden;
}
.filter-pill::before {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(255,215,0,0.08), rgba(255,140,0,0.05));
  opacity: 0; transition: opacity 0.3s; border-radius: inherit;
}
.filter-pill:hover::before, .filter-pill.active::before { opacity: 1; }
.filter-pill:hover, .filter-pill.active {
  border-color: var(--ki-gold);
  color: var(--ki-gold);
  box-shadow: 0 0 18px rgba(255,215,0,0.12), inset 0 0 16px rgba(255,215,0,0.04);
}

/* ====================================================
   v2.1 — BARRE DE RECHERCHE & TRI
   ==================================================== */
.search-sort-bar {
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 12px;
  margin-bottom: 20px;
  align-items: center;
}

.search-wrap {
  position: relative;
}

.search-input {
  width: 100%;
  background: rgba(255,255,255,0.03);
  border: 1px solid var(--border-gold);
  color: var(--text-hero);
  padding: 12px 20px 12px 48px;
  border-radius: 40px;
  font-family: 'Noto Serif JP', serif;
  font-size: 0.9rem;
  outline: none;
  transition: border-color 0.3s, box-shadow 0.3s;
}
.search-input::placeholder { color: var(--text-dim); font-style: italic; }
.search-input:focus {
  border-color: var(--ki-gold);
  box-shadow: 0 0 0 3px rgba(255,215,0,0.07), 0 0 24px rgba(255,215,0,0.1);
}

.search-icon {
  position: absolute;
  left: 16px; top: 50%;
  transform: translateY(-50%);
  color: var(--text-dim);
  font-size: 1rem;
  pointer-events: none;
  transition: color 0.3s;
}
.search-input:focus + .search-icon,
.search-wrap:focus-within .search-icon { color: var(--ki-gold); }

.search-clear {
  position: absolute;
  right: 14px; top: 50%;
  transform: translateY(-50%);
  background: rgba(255,140,0,0.12);
  border: 1px solid var(--border-hot);
  color: var(--ki-orange);
  width: 22px; height: 22px;
  border-radius: 50%;
  font-size: 0.7rem;
  cursor: pointer;
  display: none;
  align-items: center; justify-content: center;
  transition: all 0.2s;
  line-height: 1;
}
.search-clear.visible { display: flex; }
.search-clear:hover { background: rgba(255,140,0,0.3); }

.sort-select {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.75rem; letter-spacing: 0.22em;
  background: rgba(255,255,255,0.03);
  border: 1px solid var(--border-gold);
  color: var(--text-sub);
  padding: 12px 36px 12px 18px;
  border-radius: 40px;
  cursor: pointer;
  outline: none;
  appearance: none;
  -webkit-appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23FF8C00'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 14px center;
  transition: border-color 0.3s, color 0.3s;
  white-space: nowrap;
}
.sort-select:focus, .sort-select:hover {
  border-color: var(--ki-gold);
  color: var(--ki-gold);
}
.sort-select option { background: #0a0604; color: var(--text-hero); }

/* ====================================================
   v2.1 — TAGS NUAGE
   ==================================================== */
.tags-cloud {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-bottom: 28px;
  min-height: 32px;
  align-items: center;
}

.tag-chip {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.65rem; letter-spacing: 0.22em;
  color: var(--text-dim);
  border: 1px solid rgba(255,215,0,0.1);
  padding: 4px 12px;
  border-radius: 40px;
  cursor: pointer;
  transition: all 0.25s;
  background: transparent;
  position: relative;
}
.tag-chip::before { content: '#'; opacity: 0.5; margin-right: 2px; }
.tag-chip:hover {
  color: var(--ki-orange);
  border-color: var(--border-hot);
  background: rgba(255,140,0,0.05);
}
.tag-chip.active {
  color: var(--ki-gold);
  border-color: var(--ki-gold);
  background: rgba(255,215,0,0.07);
  box-shadow: 0 0 10px rgba(255,215,0,0.1);
}

/* ====================================================
   v2.1 — COMPTEUR & RÉSULTATS
   ==================================================== */
.results-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
  min-height: 28px;
  flex-wrap: wrap;
  gap: 8px;
}

.results-count {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.72rem; letter-spacing: 0.28em;
  color: var(--text-dim);
}
.results-count strong { color: var(--ki-orange); }

.search-highlight {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.68rem; letter-spacing: 0.2em;
  color: var(--text-dim);
}
.search-highlight span {
  color: var(--ki-gold);
  border-bottom: 1px solid rgba(255,215,0,0.3);
  padding-bottom: 1px;
}

/* Surlignage dans les cartes */
.hl { background: rgba(255,215,0,0.2); border-radius: 2px; color: var(--ki-gold); padding: 0 2px; }

/* ====================================================
   v2.1 — INFINITE SCROLL SENTINEL & LOADER BAS
   ==================================================== */
.scroll-sentinel {
  height: 1px;
  grid-column: 1/-1;
}

.load-more-loader {
  grid-column: 1/-1;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 14px;
  padding: 40px 0;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s;
}
.load-more-loader.active { opacity: 1; }

.load-more-ball {
  width: 36px; height: 36px; border-radius: 50%;
  background: radial-gradient(circle at 30% 28%, #FFF9C4 0%, #FFD700 20%, #FF8C00 50%, #5D1700 100%);
  box-shadow: 0 0 20px rgba(255,215,0,0.6), 0 0 40px rgba(255,140,0,0.3);
  animation: loadBounce 0.9s ease-in-out infinite;
}
.load-more-txt {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.72rem; letter-spacing: 0.4em;
  color: var(--ki-orange);
  animation: loadPulse 1.2s ease-in-out infinite;
}

/* État vide thématisé */
.empty-ki {
  grid-column: 1/-1;
  text-align: center;
  padding: 80px 24px;
  display: flex; flex-direction: column; align-items: center; gap: 18px;
}
.empty-ki-symbol {
  font-family: 'Sawarabi Mincho', serif;
  font-size: 4rem; color: rgba(255,215,0,0.08);
  line-height: 1;
}
.empty-ki-title {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 1.2rem; letter-spacing: 0.15em;
  color: var(--text-dim);
}
.empty-ki-sub {
  font-style: italic; color: var(--text-dim);
  font-size: 0.88rem; max-width: 320px; line-height: 1.7;
}
.empty-ki-reset {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.72rem; letter-spacing: 0.25em;
  background: transparent;
  border: 1px solid var(--border-hot);
  color: var(--ki-orange);
  padding: 9px 24px; border-radius: 40px;
  cursor: pointer; margin-top: 8px;
  transition: all 0.25s;
}
.empty-ki-reset:hover { background: rgba(255,140,0,0.08); box-shadow: 0 0 16px rgba(255,140,0,0.15); }

/* ====================================================
   GALLERY GRID
   ==================================================== */
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
  gap: 22px;
}

.drawing-card {
  position: relative;
  background: rgba(8,4,2,0.9);
  border: 1px solid var(--border-gold);
  border-radius: var(--radius-lg);
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.4s cubic-bezier(0.25,0.8,0.25,1), box-shadow 0.4s, border-color 0.4s;
  animation: cardIn 0.6s ease both;
}
@keyframes cardIn {
  from { opacity: 0; transform: translateY(35px) scale(0.95); }
  to   { opacity: 1; transform: none; }
}
.drawing-card:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 28px 65px rgba(0,0,0,0.75),
              0 0 0 1px var(--ki-orange),
              0 0 40px rgba(255,140,0,0.14),
              0 0 80px rgba(255,215,0,0.06);
  border-color: var(--ki-orange);
}
.drawing-card.featured { grid-column: span 2; }

.card-img-wrap {
  position: relative;
  aspect-ratio: 4/3;
  overflow: hidden;
  background: #030507;
}
.drawing-card.featured .card-img-wrap { aspect-ratio: 21/9; }
.card-img-wrap img {
  width: 100%; height: 100%;
  object-fit: cover;
  transition: transform 0.65s ease, filter 0.5s;
  filter: brightness(0.87) saturate(0.88);
}
.drawing-card:hover .card-img-wrap img {
  transform: scale(1.1);
  filter: brightness(1.05) saturate(1.18);
}

.card-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to top, rgba(2,4,8,0.82) 0%, rgba(2,4,8,0.25) 45%, transparent 70%);
  pointer-events: none;
}
.card-ki-aura {
  position: absolute; inset: 0;
  background: radial-gradient(ellipse 80% 55% at 50% 110%,
    rgba(255,140,0,0.2) 0%, rgba(255,215,0,0.08) 45%, transparent 70%
  );
  opacity: 0; transition: opacity 0.4s; pointer-events: none;
}
.drawing-card:hover .card-ki-aura { opacity: 1; }

.featured-badge {
  position: absolute; top: 12px; left: 12px; z-index: 2;
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.62rem; letter-spacing: 0.28em;
  background: linear-gradient(135deg, var(--blood-orange), var(--ki-gold));
  color: #1A0500;
  padding: 5px 14px; border-radius: 40px;
  box-shadow: 0 0 18px rgba(255,140,0,0.5);
}

.card-body { padding: 16px 20px 20px; }
.card-category {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.62rem; letter-spacing: 0.38em;
  color: var(--ki-orange); margin-bottom: 5px;
}
.card-title {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 1.2rem; letter-spacing: 0.07em;
  color: var(--text-hero); line-height: 1.15; margin-bottom: 8px;
}
.card-desc {
  font-size: 0.82rem; color: var(--text-sub);
  font-style: italic; line-height: 1.55;
  display: -webkit-box;
  -webkit-line-clamp: 2; -webkit-box-orient: vertical;
  overflow: hidden; margin-bottom: 10px;
}

/* Tags dans la carte */
.card-tags {
  display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 10px;
}
.card-tag-chip {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.58rem; letter-spacing: 0.18em;
  color: var(--text-dim);
  border: 1px solid rgba(255,215,0,0.1);
  padding: 2px 9px; border-radius: 40px;
  cursor: pointer; transition: all 0.22s;
  background: transparent;
  white-space: nowrap;
}
.card-tag-chip:hover {
  color: var(--ki-orange); border-color: var(--border-hot);
  background: rgba(255,140,0,0.06);
}
.card-footer { display: flex; align-items: center; justify-content: space-between; }
.db-mini-row { display: flex; gap: 3px; align-items: center; }
.db-mini {
  width: 12px; height: 12px; border-radius: 50%;
  position: relative; transition: transform 0.2s;
}
.db-mini.lit {
  background: radial-gradient(circle at 30% 28%, #FFF9C4 0%, #FFD700 25%, #FF8C00 55%, #8B3A00 100%);
  box-shadow: 0 0 5px rgba(255,215,0,0.75), 0 0 10px rgba(255,140,0,0.4);
}
.db-mini.lit::after {
  content: '';
  position: absolute; top: 2px; left: 2px;
  width: 3px; height: 2.5px; border-radius: 50%;
  background: rgba(255,255,230,0.65);
}
.db-mini.unlit {
  background: radial-gradient(circle at 30% 28%, #1A1206, #0A0804);
  border: 1px solid rgba(255,215,0,0.12);
}
.db-mini-count { font-family: 'Bebas Neue', sans-serif; font-size: 0.68rem; letter-spacing: 0.08em; color: var(--text-dim); margin-left: 4px; }
.card-date { font-size: 0.7rem; color: var(--text-dim); font-style: italic; }

/* No image placeholder */
.card-no-img {
  width: 100%; height: 100%;
  display: flex; align-items: center; justify-content: center;
  font-family: 'Bebas Neue', sans-serif;
  font-size: 3.5rem; letter-spacing: 0.12em;
  color: rgba(255,215,0,0.07);
  background: radial-gradient(ellipse at 50% 80%, rgba(255,140,0,0.04), transparent);
}

/* ====================================================
   MODAL
   ==================================================== */
.modal-overlay {
  position: fixed; inset: 0; z-index: 800;
  background: rgba(1, 2, 5, 0.97);
  backdrop-filter: blur(14px) saturate(0.7);
  display: flex; align-items: center; justify-content: center;
  padding: 20px;
  opacity: 0; pointer-events: none;
  transition: opacity 0.35s ease;
}
.modal-overlay.open { opacity: 1; pointer-events: all; }

.modal-container {
  width: 100%; max-width: 1080px; max-height: 92vh;
  background: rgba(8, 4, 2, 0.99);
  border: 1px solid var(--border-hot);
  border-radius: 12px;
  overflow: hidden;
  display: grid; grid-template-columns: 1fr 400px;
  position: relative;
  transform: scale(0.9) translateY(40px);
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
  box-shadow: 0 40px 120px rgba(0,0,0,0.9), 0 0 80px rgba(255,140,0,0.05);
}
.modal-overlay.open .modal-container { transform: scale(1) translateY(0); }

.modal-container::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; height: 2px;
  background: linear-gradient(90deg, transparent, var(--ki-gold), var(--ki-orange), var(--ki-gold), transparent);
  z-index: 1;
}

.modal-img-panel {
  background: #010204;
  display: flex; align-items: center; justify-content: center;
  min-height: 420px; position: relative; overflow: hidden;
  border-right: 1px solid var(--border-gold);
}
.modal-img-panel::before {
  content: '';
  position: absolute; inset: 0;
  background: radial-gradient(ellipse 80% 55% at 50% 85%, rgba(255,140,0,0.07), transparent 65%);
  pointer-events: none;
}
.modal-img-panel img {
  max-width: 100%; max-height: 80vh;
  object-fit: contain; position: relative; z-index: 1;
  transition: transform 0.4s;
  filter: drop-shadow(0 10px 40px rgba(0,0,0,0.8));
}
.modal-img-panel img:hover { transform: scale(1.04); }

.modal-info-panel {
  display: flex; flex-direction: column;
  overflow-y: auto; max-height: 92vh;
  scrollbar-width: thin;
  scrollbar-color: var(--border-gold) transparent;
}
.modal-inner { padding: 36px 30px; display: flex; flex-direction: column; gap: 22px; }

.modal-close-btn {
  position: absolute; top: 14px; right: 14px; z-index: 10;
  background: rgba(255,140,0,0.1); border: 1px solid var(--border-gold);
  color: var(--ki-gold); width: 36px; height: 36px; border-radius: 50%;
  font-size: 1rem; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: all 0.25s;
}
.modal-close-btn:hover { background: rgba(255,140,0,0.3); transform: rotate(90deg); }

.modal-cat-badge {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.62rem; letter-spacing: 0.42em;
  color: var(--ki-orange);
  border: 1px solid var(--border-hot);
  padding: 4px 14px; border-radius: 40px; display: inline-block;
}
.modal-title {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 1.85rem; letter-spacing: 0.06em; line-height: 1.1;
  color: var(--text-hero);
  text-shadow: 0 0 25px rgba(255,215,0,0.18);
}
.modal-desc {
  font-size: 0.9rem; color: var(--text-sub);
  font-style: italic; line-height: 1.8;
  border-left: 2px solid var(--blood-orange); padding-left: 14px;
}
.modal-divider { height: 1px; background: linear-gradient(90deg, var(--border-gold), transparent); }

/* ====================================================
   DRAGON BALLS WIDGET GRAND
   ==================================================== */
.rating-box {
  background: rgba(255,215,0,0.025);
  border: 1px solid var(--border-gold);
  border-radius: var(--radius-lg);
  padding: 18px;
}
.rating-box-title {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.68rem; letter-spacing: 0.42em; color: var(--ki-orange);
  margin-bottom: 14px;
  display: flex; align-items: center; gap: 10px;
}
.rating-box-title::after { content: ''; flex: 1; height: 1px; background: var(--border-gold); }

.db-row { display: flex; gap: 9px; justify-content: center; margin-bottom: 12px; }
.db-ball {
  width: 42px; height: 42px; border-radius: 50%;
  cursor: pointer; position: relative;
  transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.3s;
  background: radial-gradient(circle at 30% 28%, #1A1206, #0A0804, #050402);
  border: 1px solid rgba(255,215,0,0.12);
}
.db-ball::before {
  content: '';
  position: absolute; top: 4px; left: 6px;
  width: 28%; height: 22%; border-radius: 50%;
  background: rgba(255,255,255,0.06); pointer-events: none;
}
.db-ball-num {
  position: absolute; inset: 0;
  display: flex; align-items: center; justify-content: center;
  font-family: 'Bebas Neue', sans-serif; font-size: 0.82rem;
  color: rgba(255,255,255,0.22); pointer-events: none;
}
.db-ball.lit {
  background: radial-gradient(circle at 30% 26%,
    #FFFDE7 0%, #FFD700 18%, #FFA500 40%, #E65100 62%, #5A1500 85%, #250800 100%
  );
  border-color: var(--ki-gold);
  box-shadow: 0 0 14px rgba(255,215,0,0.9), 0 0 30px rgba(255,140,0,0.55), 0 0 60px rgba(255,100,0,0.25);
}
.db-ball.lit::before { background: rgba(255,255,235,0.55); }
.db-ball.lit .db-ball-num { color: rgba(55,18,0,0.75); }
/* Points star style canon */
.db-ball.lit::after {
  content: '';
  position: absolute; top: 9px; right: 8px;
  width: 5px; height: 5px; border-radius: 50%;
  background: rgba(70,15,0,0.55);
  box-shadow: -5px 5px 0 1px rgba(70,15,0,0.4);
  pointer-events: none;
}
.db-ball:hover { transform: scale(1.28) translateY(-4px) rotate(-8deg); z-index: 2; }
.db-ball.lit:hover { transform: scale(1.32) translateY(-5px) rotate(8deg); z-index: 2; }

.ki-phrase {
  text-align: center;
  font-family: 'Noto Serif JP', serif;
  font-size: 0.88rem; font-style: italic;
  color: var(--ki-gold);
  min-height: 22px;
  transition: all 0.3s;
  text-shadow: 0 0 18px rgba(255,215,0,0.4);
}
.ki-avg {
  text-align: center;
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.72rem; letter-spacing: 0.2em; color: var(--text-dim); margin-top: 6px;
}

/* ====================================================
   COMMENTAIRES
   ==================================================== */
.cmts-title {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.68rem; letter-spacing: 0.42em; color: var(--ki-orange);
  display: flex; align-items: center; gap: 10px;
}
.cmts-title::after { content: ''; flex: 1; height: 1px; background: var(--border-gold); }

.cmt-list { display: flex; flex-direction: column; gap: 9px; }
.cmt-item {
  background: rgba(255,255,255,0.025);
  border: 1px solid rgba(255,215,0,0.08);
  border-left: 2px solid var(--ki-orange);
  border-radius: var(--radius); padding: 11px 14px;
}
.cmt-author-row { display: flex; align-items: center; gap: 8px; margin-bottom: 4px; }
.cmt-author { font-family: 'Bebas Neue', sans-serif; font-size: 0.75rem; letter-spacing: 0.1em; color: var(--ki-gold); }
.cmt-date   { font-size: 0.68rem; color: var(--text-dim); font-style: italic; }
.cmt-text   { font-size: 0.86rem; color: var(--text-sub); line-height: 1.6; }

.cmt-form { display: flex; flex-direction: column; gap: 10px; }
.f-input, .f-textarea {
  background: rgba(255,255,255,0.03);
  border: 1px solid var(--border-gold);
  color: var(--text-hero); padding: 11px 14px;
  border-radius: var(--radius);
  font-family: 'Noto Serif JP', serif; font-size: 0.87rem;
  transition: border-color 0.3s, box-shadow 0.3s;
  resize: vertical; outline: none;
}
.f-input:focus, .f-textarea:focus {
  border-color: var(--ki-gold);
  box-shadow: 0 0 0 3px rgba(255,215,0,0.07), 0 0 18px rgba(255,215,0,0.1);
}
.f-textarea { min-height: 78px; }
.f-input::placeholder, .f-textarea::placeholder { color: var(--text-dim); font-style: italic; }

.btn-ki {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 0.78rem; letter-spacing: 0.28em;
  background: linear-gradient(135deg, var(--blood-orange), var(--ki-amber), var(--ki-gold));
  color: #1A0500;
  border: none; padding: 13px 30px;
  border-radius: var(--radius); cursor: pointer;
  transition: all 0.3s; align-self: flex-start; position: relative; overflow: hidden;
}
.btn-ki::after {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(135deg, transparent 40%, rgba(255,255,255,0.15));
  opacity: 0; transition: opacity 0.3s;
}
.btn-ki:hover::after { opacity: 1; }
.btn-ki:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(255,140,0,0.45), 0 0 50px rgba(255,215,0,0.14); }

.form-msg { padding: 9px 13px; border-radius: var(--radius); font-size: 0.83rem; display: none; }
.form-msg.success { background: rgba(46,204,113,0.08); border: 1px solid rgba(46,204,113,0.3); color: #2ecc71; display: block; }
.form-msg.error   { background: rgba(231,76,60,0.08);  border: 1px solid rgba(231,76,60,0.3);  color: #e74c3c; display: block; }

/* ====================================================
   À PROPOS
   ==================================================== */
.about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
.about-emblem-wrap { display: flex; align-items: center; justify-content: center; }
.about-emblem { position: relative; width: 300px; height: 300px; }
.emb-ring {
  position: absolute; border-radius: 50%; border: 1px solid;
  animation: ringRot linear infinite;
}
.emb-ring-1 { inset: 0; border-color: rgba(255,215,0,0.22); animation-duration: 22s; }
.emb-ring-2 { inset: 22px; border-color: rgba(255,140,0,0.18); animation-duration: 16s; animation-direction: reverse; }
.emb-ring-3 { inset: 48px; border-color: rgba(255,215,0,0.13); animation-duration: 28s; }
@keyframes ringRot { to { transform: rotate(360deg); } }
.emb-center {
  position: absolute; inset: 90px; border-radius: 50%;
  background: radial-gradient(circle at 40% 35%, rgba(255,215,0,0.12), rgba(255,140,0,0.06), rgba(2,4,8,0.95));
  border: 1px solid rgba(255,215,0,0.2);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Sawarabi Mincho', serif; font-size: 3rem; color: var(--ki-gold);
  text-shadow: var(--glow-gold);
  animation: emb-pulse 3s ease-in-out infinite;
}
@keyframes emb-pulse {
  0%,100% { text-shadow: 0 0 20px rgba(255,215,0,0.5); transform: scale(1); }
  50%     { text-shadow: 0 0 45px rgba(255,215,0,1), 0 0 90px rgba(255,140,0,0.4); transform: scale(1.06); }
}

.about-text p { font-size: 1rem; color: var(--text-sub); line-height: 1.95; margin-bottom: 18px; }
.about-text strong { color: var(--ki-gold); font-style: normal; }
.about-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 22px; }
.about-tag {
  font-family: 'Bebas Neue', sans-serif; font-size: 0.68rem; letter-spacing: 0.22em;
  color: var(--ki-orange); border: 1px solid var(--border-hot);
  padding: 5px 16px; border-radius: 40px;
  background: rgba(255,140,0,0.04);
}

/* ====================================================
   FOOTER
   ==================================================== */
.site-footer {
  border-top: 1px solid var(--border-gold);
  padding: 56px max(24px, 4vw) 40px;
  text-align: center; position: relative;
}
.site-footer::before {
  content: '';
  position: absolute; top: 0; left: 50%; transform: translateX(-50%);
  width: 50%; height: 1px;
  background: linear-gradient(90deg, transparent, var(--ki-gold), transparent);
}
.footer-logo {
  font-family: 'Bebas Neue', sans-serif; font-size: 2.2rem;
  letter-spacing: 0.12em; color: var(--ki-gold); opacity: 0.25; margin-bottom: 14px;
}
.footer-txt { font-size: 0.8rem; color: var(--text-dim); line-height: 1.9; }

/* ====================================================
   LOADING / EMPTY
   ==================================================== */
.loading-state {
  grid-column: 1/-1; text-align: center; padding: 80px 24px;
  display: flex; flex-direction: column; align-items: center; gap: 18px;
}
.loading-ball {
  width: 52px; height: 52px; border-radius: 50%;
  background: radial-gradient(circle at 30% 28%, #FFF9C4 0%, #FFD700 20%, #FF8C00 50%, #5D1700 100%);
  box-shadow: 0 0 28px rgba(255,215,0,0.7), 0 0 60px rgba(255,140,0,0.4);
  animation: loadBounce 1.1s ease-in-out infinite;
}
@keyframes loadBounce {
  0%,100% { transform: scale(0.88) translateY(0); }
  50%     { transform: scale(1.12) translateY(-14px); box-shadow: 0 0 50px rgba(255,215,0,1), 0 0 80px rgba(255,140,0,0.6); }
}
.loading-txt {
  font-family: 'Bebas Neue', sans-serif; font-size: 0.8rem;
  letter-spacing: 0.42em; color: var(--ki-orange);
  animation: loadPulse 1.5s ease-in-out infinite;
}
@keyframes loadPulse { 0%,100%{opacity:0.35} 50%{opacity:1} }
.empty-state { grid-column: 1/-1; text-align: center; padding: 80px; color: var(--text-dim); font-style: italic; }

/* ====================================================
   REVEAL SCROLL
   ==================================================== */
.reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.7s ease, transform 0.7s ease; }
.reveal.visible { opacity: 1; transform: none; }

/* ====================================================
   RESPONSIVE
   ==================================================== */
@media (max-width: 880px) {
  .modal-container { grid-template-columns: 1fr; max-height: 96vh; }
  .modal-img-panel { border-right: none; border-bottom: 1px solid var(--border-gold); min-height: 240px; }
  .modal-info-panel { max-height: 50vh; }
  .drawing-card.featured { grid-column: span 1; }
  .about-emblem-wrap { display: none; }
  .about-grid { grid-template-columns: 1fr; gap: 32px; }
}
@media (max-width: 580px) {
  .nav-links { display: none; }
  .gallery-grid { grid-template-columns: 1fr; }
  .hero-stats { gap: 30px; }
  .db-row { gap: 6px; }
  .db-ball { width: 36px; height: 36px; }
}
</style>
</head>
<body>

<!-- CURSEUR -->
<div class="cursor" id="cursor"></div>
<div class="cursor-ring" id="cursorRing"></div>

<!-- WEBGL SKY SHADER -->
<canvas id="shader-canvas"></canvas>
<div class="atmo-vignette"></div>
<div class="speedlines" id="speedlines"></div>
<div class="ki-particles" id="kiParticles"></div>

<div class="site-wrapper">

  <!-- ═══ HERO ═══ -->
  <header class="site-header" id="top">
    <div class="hero-aura"></div>

    <p class="hero-eyebrow">Portfolio Artistique · Dragon Ball Fan Art</p>

    <div class="hero-logo-wrap">
      <div class="hero-logo-stroke" aria-hidden="true">SAIYAN<br>ARTS</div>
      <div class="hero-logo">SAIYAN<br>ARTS</div>
    </div>

    <p class="hero-subtitle">L'Art Prend une Forme Légendaire</p>

    <div class="hero-separator">
      <div class="sep-line"></div>
      <div class="sep-diamond"></div>
      <div class="sep-line"></div>
    </div>

    <div class="hero-stats">
      <div class="hero-stat">
        <div class="hero-stat-num" id="statDrawings">—</div>
        <div class="hero-stat-label">Œuvres</div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-num" id="statVotes">—</div>
        <div class="hero-stat-label">Votes Ki</div>
      </div>
      <div class="hero-stat">
        <div class="hero-stat-num" id="statComments">—</div>
        <div class="hero-stat-label">Guerriers</div>
      </div>
    </div>

    <div class="scroll-hint">
      <span>Parcourir</span>
      <div class="scroll-chevron"></div>
    </div>
  </header>

  <!-- ═══ NAV ═══ -->
  <nav class="main-nav">
    <a href="#top" class="nav-brand">SAIYAN ARTS</a>
    <ul class="nav-links">
      <li><a href="#gallery" class="active">Galerie</a></li>
      <li><a href="#about">L'Artiste</a></li>
      <li><a href="admin/" target="_blank">Admin</a></li>
    </ul>
    <div class="nav-power">⚡ Power Level: OVER 9000</div>
  </nav>

  <!-- ═══ GALERIE ═══ -->
  <section id="gallery" class="section">
    <div class="section-header reveal">
      <div class="section-chapter">Chapitre I</div>
      <h2 class="section-title">Galerie des Guerriers</h2>
      <span class="section-title-jp">戦士たちのギャラリー</span>
      <div class="section-orn">
        <div class="orn-line"></div>
        <div class="orn-diamond"></div>
        <div class="orn-line"></div>
      </div>
    </div>

    <!-- Catégories -->
    <div class="filter-bar reveal" id="filterBar">
      <button class="filter-pill active" data-cat="">Tous</button>
      <button class="filter-pill" data-cat="fanart">Fan Art</button>
      <button class="filter-pill" data-cat="original">Original</button>
      <button class="filter-pill" data-cat="sketch">Croquis</button>
      <button class="filter-pill" data-cat="colored">Colorié</button>
    </div>

    <!-- Recherche + Tri -->
    <div class="search-sort-bar reveal">
      <div class="search-wrap">
        <input class="search-input" type="text" id="searchInput"
          placeholder="Rechercher un guerrier, une technique, un arc…"
          maxlength="100" autocomplete="off" spellcheck="false">
        <span class="search-icon">🔍</span>
        <button class="search-clear" id="searchClear" title="Effacer">✕</button>
      </div>
      <select class="sort-select" id="sortSelect">
        <option value="recent">Plus récents</option>
        <option value="top">Mieux notés</option>
        <option value="votes">Plus votés</option>
        <option value="oldest">Plus anciens</option>
        <option value="random">Aléatoire</option>
      </select>
    </div>

    <!-- Nuage de tags -->
    <div class="tags-cloud reveal" id="tagsCloud"></div>

    <!-- Compteur de résultats -->
    <div class="results-bar" id="resultsBar" style="display:none">
      <div class="results-count" id="resultsCount"></div>
      <div class="search-highlight" id="searchHighlightLabel"></div>
    </div>

    <!-- Grille principale -->
    <div id="galleryGrid" class="gallery-grid">
      <div class="loading-state">
        <div class="loading-ball"></div>
        <div class="loading-txt">Chargement du Ki...</div>
      </div>
    </div>

  </section>

  <!-- ═══ ABOUT ═══ -->
  <section id="about" class="section">
    <div class="section-header reveal">
      <div class="section-chapter">Chapitre II</div>
      <h2 class="section-title">L'Artiste</h2>
      <span class="section-title-jp">芸術家について</span>
      <div class="section-orn">
        <div class="orn-line"></div>
        <div class="orn-diamond"></div>
        <div class="orn-line"></div>
      </div>
    </div>
    <div class="about-grid">
      <div class="about-emblem-wrap reveal">
        <div class="about-emblem">
          <div class="emb-ring emb-ring-1"></div>
          <div class="emb-ring emb-ring-2"></div>
          <div class="emb-ring emb-ring-3"></div>
          <div class="emb-center">気</div>
        </div>
      </div>
      <div class="about-text reveal">
        <p>Depuis l'enfance, l'univers de <strong>Dragon Ball Z</strong> a façonné ma vision de l'art et du mouvement. Le trait de Toriyama — à la fois précis et explosif — m'a appris que chaque ligne peut contenir une <strong>énergie infinie</strong>.</p>
        <p>Ces illustrations naissent d'une volonté de capturer non seulement la puissance physique des personnages, mais aussi leur essence spirituelle — ce <strong>Ki invisible</strong> qui transcende toute limite.</p>
        <p>Chaque dessin est un entraînement. Chaque trait, un pas de plus vers la maîtrise. <strong>L'art, comme le combat, ne s'arrête jamais.</strong></p>
        <div class="about-tags">
          <span class="about-tag">Encre & Stylo</span>
          <span class="about-tag">Aquarelle</span>
          <span class="about-tag">Numérique</span>
          <span class="about-tag">Croquis Manga</span>
          <span class="about-tag">Fan Art DBZ</span>
          <span class="about-tag">Personnages OC</span>
        </div>
      </div>
    </div>
  </section>

  <footer class="site-footer">
    <div class="footer-logo">SAIYAN ARTS</div>
    <p class="footer-txt">
      Inspiré par l'univers Dragon Ball Z — Créé par Akira Toriyama<br>
      <span style="opacity:.5;font-size:.75rem">Œuvre de fan art non commerciale · <?= date('Y') ?></span>
    </p>
  </footer>

</div>

<!-- ═══ MODAL ═══ -->
<div class="modal-overlay" id="modal" role="dialog" aria-modal="true">
  <div class="modal-container">
    <button class="modal-close-btn" id="modalClose" aria-label="Fermer">✕</button>
    <div class="modal-img-panel">
      <img src="" alt="" id="modalImg">
    </div>
    <div class="modal-info-panel">
      <div class="modal-inner">
        <div class="modal-cat-badge" id="modalCat"></div>
        <div class="modal-title" id="modalTitle"></div>
        <p class="modal-desc" id="modalDesc" style="display:none"></p>
        <div class="modal-divider"></div>

        <!-- RATING DBZ -->
        <div class="rating-box">
          <div class="rating-box-title">NOTER CETTE ŒUVRE</div>
          <div class="db-row" id="dbRow"></div>
          <div class="ki-phrase" id="kiPhrase"></div>
          <div class="ki-avg" id="kiAvg"></div>
        </div>

        <div class="modal-divider"></div>

        <!-- COMMENTS -->
        <div>
          <div class="cmts-title" style="margin-bottom:14px">COMMENTAIRES DES GUERRIERS</div>
          <div id="cmtList" class="cmt-list"></div>
        </div>
        <div class="modal-divider"></div>
        <div class="cmt-form">
          <input class="f-input" type="text" id="cAuthor" placeholder="Ton nom de guerrier…" maxlength="80">
          <textarea class="f-textarea" id="cContent" placeholder="Ton message, guerrier…" maxlength="1000"></textarea>
          <div class="form-msg" id="cMsg"></div>
          <button class="btn-ki" id="cSubmit">⚡ LANCER LE KI</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
'use strict';

// ─────────────────────────────────────────
// 1. CURSEUR KI
// ─────────────────────────────────────────
const $cursor = document.getElementById('cursor');
const $ring   = document.getElementById('cursorRing');
let cx=0, cy=0, rx=0, ry=0;

document.addEventListener('mousemove', e => {
  cx = e.clientX; cy = e.clientY;
  $cursor.style.left = cx + 'px';
  $cursor.style.top  = cy + 'px';
});

(function animRing() {
  rx += (cx - rx) * 0.13;
  ry += (cy - ry) * 0.13;
  $ring.style.left = rx + 'px';
  $ring.style.top  = ry + 'px';
  requestAnimationFrame(animRing);
})();

document.querySelectorAll('a,button,.drawing-card,.filter-pill,.db-ball').forEach(el => {
  el.addEventListener('mouseenter', () => {
    $cursor.style.transform = 'translate(-50%,-50%) scale(2.2)';
    $ring.style.width = $ring.style.height = '58px';
  });
  el.addEventListener('mouseleave', () => {
    $cursor.style.transform = 'translate(-50%,-50%) scale(1)';
    $ring.style.width = $ring.style.height = '36px';
  });
});

// ─────────────────────────────────────────
// 2. GLSL SHADER — CIEL COSMIQUE DBZ
// ─────────────────────────────────────────
(function initGLSL() {
  const canvas   = document.getElementById('shader-canvas');
  const renderer = new THREE.WebGLRenderer({ canvas, antialias: false });
  renderer.setPixelRatio(Math.min(devicePixelRatio, 1.5));

  const scene  = new THREE.Scene();
  const camera = new THREE.OrthographicCamera(-1,1,1,-1,0,1);

  const frag = `
    precision mediump float;
    uniform vec2  u_res;
    uniform float u_t;
    uniform vec2  u_mouse;

    float hash(vec2 p){
      p=fract(p*vec2(127.1,311.7));
      p+=dot(p,p+19.19);
      return fract(p.x*p.y);
    }
    float noise(vec2 p){
      vec2 i=floor(p), f=fract(p), u=f*f*(3.0-2.0*f);
      return mix(mix(hash(i),hash(i+vec2(1,0)),u.x),
                 mix(hash(i+vec2(0,1)),hash(i+vec2(1,1)),u.x),u.y);
    }
    float fbm(vec2 p){
      float v=0.,a=.5;
      for(int i=0;i<6;i++){v+=a*noise(p);a*=.5;p*=2.02;}
      return v;
    }
    float star(vec2 uv, float density, float seed){
      vec2 g=floor(uv*density);
      vec2 f=fract(uv*density)-.5;
      float h=hash(g+seed);
      float tw=.65+.35*sin(u_t*(1.2+h*3.5)+h*6.28);
      return smoothstep(.055,.0,length(f))*tw*step(.91,h);
    }
    void main(){
      vec2 uv=gl_FragCoord.xy/u_res;
      float asp=u_res.x/u_res.y;
      vec2 uvA=vec2(uv.x*asp,uv.y);
      vec2 mouse=u_mouse/u_res;

      // Fond cosmos profond
      vec3 col=mix(vec3(.006,.010,.024),vec3(.016,.028,.062),uv.y*.6);
      col=mix(col,vec3(.022,.012,.004),pow(1.0-uv.y,3.0)*.5);

      // Nébuleuse orange chaude (bas-centre)
      float n1=fbm(uvA*1.6+vec2(u_t*.009,.5));
      float nm1=smoothstep(.42,.82,n1);
      vec3 nebOrange=vec3(.4,.15,.02)*nm1*.65;
      col+=nebOrange*smoothstep(.8,.3,abs(uv.x-.5)*1.8)*(1.0-uv.y*.5);

      // Nébuleuse bleue-nuit (haut-droite)
      float n2=fbm(uvA*2.1+vec2(1.2,-u_t*.006));
      float nm2=smoothstep(.46,.80,n2);
      vec3 nebBlue=vec3(.02,.055,.20)*nm2*.45;
      col+=nebBlue*smoothstep(.0,.7,uv.x)*smoothstep(.2,.9,uv.y);

      // Nébuleuse pourpre (haut-gauche, subtil)
      float n3=fbm(uvA*1.4+vec2(-u_t*.007,.8));
      float nm3=smoothstep(.48,.80,n3);
      col+=vec3(.10,.02,.12)*nm3*.3*smoothstep(.6,.0,uv.x)*smoothstep(.4,1.,uv.y);

      // Aura ki dorée centrale bas
      vec2 auraCtr=vec2(.5+sin(u_t*.12)*.035,-.08);
      float aura=exp(-pow(length((uv-auraCtr)*vec2(1.0,.75)),2.0)*7.0);
      aura*=.55+.45*sin(u_t*.75+.5);
      col+=vec3(.7,.38,.0)*aura*.38;

      // Second aura plus large orange-rouge
      float aura2=exp(-pow(length((uv-vec2(.5,-.05))*vec2(.8,.6)),2.0)*4.0);
      aura2*=.45+.45*sin(u_t*.5);
      col+=vec3(.45,.12,.0)*aura2*.22;

      // Rayons Ki (speedlines cosmiques)
      float ky=(uv.x-.5+mouse.x*.04)*16.0+u_t*.25;
      float kiRays=pow(abs(cos(ky)),22.0)*(1.0-uv.y*.6);
      kiRays*=fbm(uvA*2.5+u_t*.04)*1.4;
      col+=vec3(.9,.52,.0)*kiRays*.14;

      // Étoiles — 4 couches
      float s1=star(uv+vec2(u_t*.0008,0.),85.,0.0);
      float s2=star(uv*1.35+vec2(.1,u_t*.0006),150.,7.3)*.55;
      float s3=star(uv*.72+vec2(-.04,.03),55.,3.1)*.75;
      float s4=star(uv*2.1+vec2(u_t*.0012,.25),200.,.4)*.35;
      col+=s1*vec3(1.,.97,.88)+s2*vec3(.78,.88,1.)+s3*vec3(1.,.9,.5)+s4*vec3(1.,.95,.8);

      // Étoile filante
      float st=fract(u_t*.065);
      vec2 sp=vec2(.92-st*1.85,.82-st*.38);
      float shoot=exp(-length((uv-sp)*vec2(1.,5.))*42.0)*step(st,.42)*1.6;
      col+=vec3(1.,.95,.7)*shoot;

      // Traînée de l'étoile filante
      float trail=exp(-length((uv-(sp+vec2(.06,.015)))*vec2(1.,4.))*30.0)*step(st,.38)*.5;
      col+=vec3(.9,.75,.4)*trail;

      // Vignetage
      float vig=1.0-smoothstep(.3,1.45,length((uv-.5)*vec2(1.25,1.)));
      col*=vig;

      // Grain cinématique léger
      col+=hash(uv+fract(u_t))*.022-.011;

      // Correction gamma
      col=pow(max(col,vec3(0.)),vec3(.9));
      gl_FragColor=vec4(col,1.);
    }
  `;

  const mat = new THREE.ShaderMaterial({
    fragmentShader: frag,
    vertexShader: 'void main(){gl_Position=vec4(position,1.);}',
    uniforms: {
      u_res:   { value: new THREE.Vector2() },
      u_t:     { value: 0.0 },
      u_mouse: { value: new THREE.Vector2() }
    }
  });

  scene.add(new THREE.Mesh(new THREE.PlaneGeometry(2,2), mat));

  function resize() {
    const w=innerWidth, h=innerHeight;
    renderer.setSize(w,h,false);
    mat.uniforms.u_res.value.set(w,h);
  }
  resize();
  addEventListener('resize', resize);
  addEventListener('mousemove', e => mat.uniforms.u_mouse.value.set(e.clientX, e.clientY));

  let t=0;
  (function loop() { t+=.016; mat.uniforms.u_t.value=t; renderer.render(scene,camera); requestAnimationFrame(loop); })();
})();

// ─────────────────────────────────────────
// 3. PARTICULES KI
// ─────────────────────────────────────────
(function spawnKi() {
  const c = document.getElementById('kiParticles');
  function mkParticle() {
    const p = document.createElement('div');
    p.className = 'ki-particle';
    const dur = 7 + Math.random()*11;
    p.style.cssText = `left:${Math.random()*100}%;height:${28+Math.random()*100}px;`+
      `animation-duration:${dur}s;animation-delay:${Math.random()*20}s;`+
      `opacity:${.3+Math.random()*.6}`;
    c.appendChild(p);
    setTimeout(() => p.remove(), (dur+21)*1000);
  }
  for(let i=0;i<70;i++) mkParticle();
  setInterval(mkParticle, 700);
})();

// ─────────────────────────────────────────
// 4. SCROLL REVEAL
// ─────────────────────────────────────────
const obs = new IntersectionObserver(entries => {
  entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('visible'); obs.unobserve(e.target); } });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

// ─────────────────────────────────────────
// 5. APP v2.1 — STATE & CONFIG
// ─────────────────────────────────────────
const API    = 'php/api/drawings.php';
const LIMIT  = 12;

// État centralisé de la galerie
const state = {
  cat:      '',
  q:        '',
  sort:     'recent',
  tag:      '',
  offset:   0,
  total:    0,
  loading:  false,
  hasMore:  false,
};

let activeDrawing = null;
let pickedRating  = 0;
let searchDebounce = null;

const kiPhrases = [
  '', '…Un souffle de Ki.', 'Le Ki s\'éveille…',
  '⚡ Niveau tournoi !', '🔥 SUPER SAIYAN !',
  '💥 SSJ2 DÉCLENCHÉ !!', '⚡⚡ SSJ3 — PUISSANCE ULTIME !!!',
  '🐉 OVER 9000 — ABSOLUMENT LÉGENDAIRE !!'
];

// ─────────────────────────────────────────
// 5a. URL PARAMS — lecture & écriture
// ─────────────────────────────────────────
function readURLParams() {
  const p = new URLSearchParams(location.search);
  state.cat  = p.get('cat')  || '';
  state.q    = p.get('q')    || '';
  state.sort = p.get('sort') || 'recent';
  state.tag  = p.get('tag')  || '';
}

function writeURLParams() {
  const p = new URLSearchParams();
  if (state.cat)  p.set('cat',  state.cat);
  if (state.q)    p.set('q',    state.q);
  if (state.sort && state.sort !== 'recent') p.set('sort', state.sort);
  if (state.tag)  p.set('tag',  state.tag);
  const qs = p.toString();
  history.replaceState(null, '', qs ? '?' + qs + '#gallery' : location.pathname + '#gallery');
}

function syncUIFromState() {
  // Catégorie
  document.querySelectorAll('.filter-pill').forEach(p => {
    p.classList.toggle('active', p.dataset.cat === state.cat);
  });
  // Recherche
  const inp = document.getElementById('searchInput');
  if (inp) inp.value = state.q;
  toggleClearBtn();
  // Tri
  const sel = document.getElementById('sortSelect');
  if (sel) sel.value = state.sort;
  // Tag actif
  document.querySelectorAll('.tag-chip').forEach(c => {
    c.classList.toggle('active', c.dataset.tag === state.tag);
  });
}

// ─────────────────────────────────────────
// 5b. CHARGEMENT GALERIE — reset + append
// ─────────────────────────────────────────
async function loadDrawings(reset = true) {
  if (state.loading) return;
  state.loading = true;

  if (reset) {
    state.offset = 0;
    const grid = document.getElementById('galleryGrid');
    grid.innerHTML = `<div class="loading-state">
      <div class="loading-ball"></div>
      <div class="loading-txt">Chargement du Ki...</div>
    </div>`;
    document.getElementById('resultsBar').style.display = 'none';
  } else {
    showInfiniteLoader(true);
  }

  writeURLParams();

  const params = new URLSearchParams({
    action: 'list',
    limit:  LIMIT,
    offset: state.offset,
    sort:   state.sort,
  });
  if (state.cat) params.set('category', state.cat);
  if (state.q)   params.set('q', state.q);
  if (state.tag) params.set('tag', state.tag);

  try {
    const res  = await fetch(`${API}?${params}`);
    const data = await res.json();
    state.loading = false;
    showInfiniteLoader(false);

    if (!data.success) { renderEmpty(); return; }

    state.total   = data.total   ?? 0;
    state.hasMore = (state.offset + LIMIT) < state.total;

    // Stats héros
    if (reset) {
      document.getElementById('statDrawings').textContent = state.total;
    }

    const grid = document.getElementById('galleryGrid');

    if (reset) {
      grid.innerHTML = '';
      if (!data.drawings?.length) { renderEmpty(grid); return; }
    }

    const drawings = data.drawings || [];
    drawings.forEach((d, i) => {
      const card = buildCard(d, reset ? i : state.offset + i);
      grid.appendChild(card);
      obs.observe(card);
    });

    // Ajouter le sentinel APRÈS les cartes (pour l'infinite scroll)
    let sentinel = document.getElementById('scrollSentinel');
    if (!sentinel) {
      sentinel = document.createElement('div');
      sentinel.id = 'scrollSentinel';
      sentinel.className = 'scroll-sentinel';
    }
    grid.appendChild(sentinel);

    // Loader "bas de page"
    let loaderEl = document.getElementById('infiniteLoader');
    if (!loaderEl) {
      loaderEl = document.createElement('div');
      loaderEl.id = 'infiniteLoader';
      loaderEl.className = 'load-more-loader';
      loaderEl.innerHTML = '<div class="load-more-ball"></div><div class="load-more-txt">Chargement...</div>';
    }
    grid.appendChild(loaderEl);

    state.offset += drawings.length;

    // Réobserver sentinel
    if (state.hasMore) {
      sentinelObserver.observe(sentinel);
    } else {
      sentinelObserver.unobserve(sentinel);
    }

    updateResultsBar();

  } catch (err) {
    state.loading = false;
    showInfiniteLoader(false);
    const grid = document.getElementById('galleryGrid');
    grid.innerHTML = '';
    demoCards(grid);
  }
}

function showInfiniteLoader(on) {
  const el = document.getElementById('infiniteLoader');
  if (el) el.classList.toggle('active', on);
}

// ─────────────────────────────────────────
// 5c. BARRE DE RÉSULTATS
// ─────────────────────────────────────────
function updateResultsBar() {
  const bar   = document.getElementById('resultsBar');
  const count = document.getElementById('resultsCount');
  const hl    = document.getElementById('searchHighlightLabel');

  const shown = Math.min(state.offset, state.total);
  bar.style.display = 'flex';

  if (state.total === 0) {
    count.innerHTML = 'Aucun résultat';
  } else {
    count.innerHTML = `Affichage <strong>${shown}</strong> / <strong>${state.total}</strong> œuvre${state.total > 1 ? 's' : ''}`;
  }

  if (state.q) {
    hl.innerHTML = `Recherche : <span>${esc(state.q)}</span>`;
  } else if (state.tag) {
    hl.innerHTML = `Tag actif : <span>#${esc(state.tag)}</span>`;
  } else {
    hl.textContent = '';
  }
}

// ─────────────────────────────────────────
// 5d. ÉTAT VIDE THÉMATISÉ
// ─────────────────────────────────────────
function renderEmpty(grid) {
  grid = grid || document.getElementById('galleryGrid');
  const hasFilters = state.q || state.cat || state.tag;
  grid.innerHTML = `
    <div class="empty-ki">
      <div class="empty-ki-symbol">無</div>
      <div class="empty-ki-title">${hasFilters ? 'Aucun guerrier trouvé' : 'Galerie vide'}</div>
      <p class="empty-ki-sub">
        ${hasFilters
          ? 'Aucune œuvre ne correspond à ta recherche. Essaie un autre terme ou un autre filtre.'
          : 'Aucun dessin n\'a encore été ajouté. Visite le panneau admin pour uploader tes œuvres !'}
      </p>
      ${hasFilters ? `<button class="empty-ki-reset" id="emptyReset">Réinitialiser les filtres</button>` : ''}
    </div>`;
  document.getElementById('resultsBar').style.display = 'none';
  const resetBtn = document.getElementById('emptyReset');
  if (resetBtn) resetBtn.addEventListener('click', resetFilters);
}

function resetFilters() {
  state.cat = ''; state.q = ''; state.tag = ''; state.sort = 'recent';
  syncUIFromState();
  loadDrawings(true);
}

// ─────────────────────────────────────────
// 5e. INFINITE SCROLL (IntersectionObserver)
// ─────────────────────────────────────────
const sentinelObserver = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting && state.hasMore && !state.loading) {
      loadDrawings(false);
    }
  });
}, { rootMargin: '200px' });

// ─────────────────────────────────────────
// 5f. CONSTRUCTION DES CARTES + HIGHLIGHT
// ─────────────────────────────────────────
function highlight(text, query) {
  if (!query || !text) return esc(text || '');
  const escaped = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  const re = new RegExp('(' + escaped + ')', 'gi');
  return esc(text).replace(re, '<span class="hl">$1</span>');
}

function buildCard(d, i) {
  const el = document.createElement('div');
  el.className = 'drawing-card reveal' + (d.is_featured ? ' featured' : '');
  el.style.animationDelay = (Math.min(i, 8) * 0.06) + 's';

  const filled  = Math.round(d.avg_rating || 0);
  const dbHtml  = Array.from({length:7}, (_,j) =>
    `<div class="db-mini ${j < filled ? 'lit' : 'unlit'}"></div>`
  ).join('');

  const imgEl = d.filename
    ? `<img src="uploads/drawings/${esc(d.filename)}" alt="${esc(d.title)}" loading="lazy">`
    : `<div class="card-no-img">気</div>`;

  // Tags de la carte (max 3 affichés)
  const tags = d.tags ? d.tags.split(',').map(t => t.trim()).filter(Boolean).slice(0, 3) : [];
  const tagsHtml = tags.length
    ? `<div class="card-tags">${tags.map(t =>
        `<span class="card-tag-chip" data-tag="${esc(t)}">#${esc(t)}</span>`
      ).join('')}</div>`
    : '';

  el.innerHTML = `
    <div class="card-img-wrap">
      ${imgEl}
      <div class="card-overlay"></div>
      <div class="card-ki-aura"></div>
      ${d.is_featured ? '<span class="featured-badge">★ EN VEDETTE</span>' : ''}
    </div>
    <div class="card-body">
      <div class="card-category">${esc(d.category || 'fanart')}</div>
      <div class="card-title">${highlight(d.title, state.q)}</div>
      ${d.description ? `<div class="card-desc">${highlight(d.description, state.q)}</div>` : ''}
      ${tagsHtml}
      <div class="card-footer">
        <div class="db-mini-row">${dbHtml}<span class="db-mini-count">${d.vote_count || 0}</span></div>
        <span class="card-date">${(d.created_at || '').slice(0, 10)}</span>
      </div>
    </div>`;

  // Clic sur la carte = modal
  el.addEventListener('click', e => {
    // Ne pas ouvrir le modal si on clique sur un tag
    if (e.target.classList.contains('card-tag-chip')) return;
    openModal(d);
  });

  // Clic sur un tag = filtrer par tag
  el.querySelectorAll('.card-tag-chip').forEach(chip => {
    chip.addEventListener('click', e => {
      e.stopPropagation();
      const t = chip.dataset.tag;
      if (state.tag === t) {
        state.tag = '';
      } else {
        state.tag = t;
        state.q   = '';
        document.getElementById('searchInput').value = '';
        toggleClearBtn();
      }
      document.querySelectorAll('.tag-chip').forEach(c =>
        c.classList.toggle('active', c.dataset.tag === state.tag)
      );
      loadDrawings(true);
    });
  });

  return el;
}

// ─────────────────────────────────────────
// 5g. DÉMO OFFLINE
// ─────────────────────────────────────────
function demoCards(grid) {
  const demos = [
    {id:1,title:'GOKU — SSJ3',description:'La transformation ultime de Son Goku',category:'fanart',tags:'Goku,SuperSaiyan,transformation',avg_rating:6.5,vote_count:42,is_featured:1},
    {id:2,title:'VEGETA — PRINCE DES SAIYANS',description:'La fierté du prince des Saiyans',category:'fanart',tags:'Vegeta,Saiyan,prince',avg_rating:5.8,vote_count:31,is_featured:0},
    {id:3,title:'GOHAN VS CELL',description:'Le combat décisif du Tournoi Cell',category:'colored',tags:'Gohan,Cell,combat',avg_rating:7,vote_count:58,is_featured:0},
    {id:4,title:'TRUNKS DU FUTUR',description:'Épée à la main, déterminé',category:'sketch',tags:'Trunks,futur,épée',avg_rating:4.2,vote_count:15,is_featured:0},
    {id:5,title:'PICCOLO — NAMEKIEN',description:'Le guerrier stratège en méditation',category:'original',tags:'Piccolo,Namek,méditation',avg_rating:5,vote_count:22,is_featured:0},
    {id:6,title:'FREEZER — FORME FINALE',description:'La terreur de l\'univers',category:'colored',tags:'Freezer,méchant,espace',avg_rating:6,vote_count:37,is_featured:0},
  ];
  let tv = 0;
  demos.forEach((d,i) => { tv += d.vote_count; grid.appendChild(buildCard(d,i)); });
  document.getElementById('statDrawings').textContent = demos.length;
  document.getElementById('statVotes').textContent    = tv;
  document.getElementById('statComments').textContent = '—';
  state.total = demos.length;
  state.offset = demos.length;
  grid.querySelectorAll('.drawing-card').forEach(el => obs.observe(el));
  updateResultsBar();
}

function esc(s) {
  const d = document.createElement('div');
  d.textContent = String(s || '');
  return d.innerHTML;
}

// ─────────────────────────────────────────
// 5h. NUAGE DE TAGS
// ─────────────────────────────────────────
async function loadTagsCloud() {
  try {
    const res  = await fetch(`${API}?action=tags_list`);
    const data = await res.json();
    renderTagsCloud(data.tags || {});
  } catch {
    // Démo offline : tags fixes
    renderTagsCloud({Goku:5,Vegeta:4,SuperSaiyan:6,combat:3,Gohan:2,Freezer:2,Piccolo:2,Trunks:2,espace:1});
  }
}

function renderTagsCloud(tags) {
  const cloud = document.getElementById('tagsCloud');
  const entries = Object.entries(tags).slice(0, 18); // max 18 tags
  if (!entries.length) { cloud.style.display = 'none'; return; }

  cloud.innerHTML = entries.map(([tag, count]) => `
    <button class="tag-chip${state.tag === tag ? ' active' : ''}" data-tag="${esc(tag)}" title="${count} œuvre${count>1?'s':''}">
      ${esc(tag)}
    </button>`
  ).join('');

  cloud.querySelectorAll('.tag-chip').forEach(chip => {
    chip.addEventListener('click', () => {
      const t = chip.dataset.tag;
      if (state.tag === t) {
        state.tag = '';
      } else {
        state.tag = t;
        state.q   = '';
        document.getElementById('searchInput').value = '';
        toggleClearBtn();
      }
      document.querySelectorAll('.tag-chip, .card-tag-chip').forEach(c =>
        c.classList.toggle('active', c.dataset.tag === state.tag)
      );
      loadDrawings(true);
    });
  });
}

// ─────────────────────────────────────────
// 5i. RECHERCHE LIVE — debounce 300ms
// ─────────────────────────────────────────
function toggleClearBtn() {
  const inp = document.getElementById('searchInput');
  const btn = document.getElementById('searchClear');
  if (!inp || !btn) return;
  btn.classList.toggle('visible', inp.value.trim().length > 0);
}

document.getElementById('searchInput').addEventListener('input', e => {
  toggleClearBtn();
  clearTimeout(searchDebounce);
  searchDebounce = setTimeout(() => {
    const q = e.target.value.trim();
    if (q === state.q) return;
    state.q   = q;
    state.tag = q ? '' : state.tag; // réinitialise le tag actif si on tape
    if (q) {
      document.querySelectorAll('.tag-chip').forEach(c => c.classList.remove('active'));
    }
    loadDrawings(true);
  }, 300);
});

document.getElementById('searchClear').addEventListener('click', () => {
  document.getElementById('searchInput').value = '';
  toggleClearBtn();
  if (state.q) { state.q = ''; loadDrawings(true); }
});

// Touche Escape vide la recherche
document.getElementById('searchInput').addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    document.getElementById('searchInput').value = '';
    toggleClearBtn();
    if (state.q) { state.q = ''; loadDrawings(true); }
  }
});

// ─────────────────────────────────────────
// 5j. TRI
// ─────────────────────────────────────────
document.getElementById('sortSelect').addEventListener('change', e => {
  state.sort = e.target.value;
  loadDrawings(true);
});

// ─────────────────────────────────────────
// 5k. FILTRES CATÉGORIE
// ─────────────────────────────────────────
document.querySelectorAll('.filter-pill').forEach(p => {
  p.addEventListener('click', () => {
    document.querySelectorAll('.filter-pill').forEach(x => x.classList.remove('active'));
    p.classList.add('active');
    state.cat = p.dataset.cat;
    loadDrawings(true);
  });
});
// ─────────────────────────────────────────
// 6. MODAL
// ─────────────────────────────────────────
async function openModal(d) {
  activeDrawing = d; pickedRating = 0;

  document.getElementById('modalImg').src = d.filename?`uploads/drawings/${d.filename}`:'';
  document.getElementById('modalImg').alt = d.title||'';
  document.getElementById('modalTitle').textContent = d.title||'';
  document.getElementById('modalCat').textContent   = (d.category||'fanart').toUpperCase();

  const descEl = document.getElementById('modalDesc');
  descEl.textContent = d.description||'';
  descEl.style.display = d.description?'block':'none';

  document.getElementById('cMsg').className = 'form-msg';
  document.getElementById('cMsg').textContent = '';

  buildDBWidget(d);
  document.getElementById('cmtList').innerHTML = '<div class="loading-txt" style="font-size:.78rem;padding:8px 0">Chargement…</div>';

  document.getElementById('modal').classList.add('open');
  document.body.style.overflow = 'hidden';

  // Effet speedlines
  const sl = document.getElementById('speedlines');
  sl.style.opacity = '1';
  setTimeout(() => sl.style.opacity = '0', 700);

  try {
    const res  = await fetch(`${API}?action=single&id=${d.id}`);
    const data = await res.json();
    if(data.success) renderCmts(data.drawing.comments||[]);
  } catch { renderCmts([]); }
}

function closeModal() {
  document.getElementById('modal').classList.remove('open');
  document.body.style.overflow = '';
  activeDrawing = null;
}
document.getElementById('modalClose').addEventListener('click', closeModal);
document.getElementById('modal').addEventListener('click', e => { if(e.target===document.getElementById('modal')) closeModal(); });
document.addEventListener('keydown', e => { if(e.key==='Escape') closeModal(); });

// ─────────────────────────────────────────
// 7. DRAGON BALLS WIDGET
// ─────────────────────────────────────────
function buildDBWidget(d) {
  const row    = document.getElementById('dbRow');
  const phrase = document.getElementById('kiPhrase');
  const avg    = document.getElementById('kiAvg');
  row.innerHTML = '';
  const filled = Math.round(d.avg_rating||0);

  for(let i=1;i<=7;i++) {
    const b=document.createElement('div');
    b.className='db-ball'+(i<=filled?' lit':'');
    b.innerHTML=`<span class="db-ball-num">${i}</span>`;
    b.addEventListener('mouseenter',()=>{ highlightDB(i); phrase.textContent=kiPhrases[i]||''; });
    b.addEventListener('mouseleave',()=>{ highlightDB(pickedRating||filled); phrase.textContent=pickedRating?kiPhrases[pickedRating]:''; });
    b.addEventListener('click',()=>castVote(i));
    row.appendChild(b);
  }

  avg.textContent = d.vote_count
    ? `Moyenne : ⚡ ${Number(d.avg_rating||0).toFixed(1)} / 7  ·  ${d.vote_count} vote${d.vote_count>1?'s':''}`
    : 'Aucun vote pour l\'instant.';
  phrase.textContent='';
}

function highlightDB(n) {
  document.querySelectorAll('#dbRow .db-ball').forEach((b,i)=>b.classList.toggle('lit',i<n));
}

async function castVote(rating) {
  if(!activeDrawing) return;
  pickedRating = rating;
  try {
    const res  = await fetch(`${API}?action=vote`,{
      method:'POST', headers:{'Content-Type':'application/json'},
      body: JSON.stringify({drawing_id:activeDrawing.id,rating})
    });
    const data = await res.json();
    const phrase=document.getElementById('kiPhrase'), avg=document.getElementById('kiAvg');
    if(data.success) {
      activeDrawing.avg_rating=data.avg_rating; activeDrawing.vote_count=data.vote_count;
      phrase.textContent='✅ '+kiPhrases[rating];
      avg.textContent=`Moyenne : ⚡ ${Number(data.avg_rating).toFixed(1)} / 7  ·  ${data.vote_count} votes`;
      highlightDB(Math.round(data.avg_rating));
    } else { phrase.textContent=data.error||'Erreur de vote.'; }
  } catch { document.getElementById('kiPhrase').textContent='Serveur inaccessible.'; }
}

// ─────────────────────────────────────────
// 8. COMMENTAIRES
// ─────────────────────────────────────────
function renderCmts(cmts) {
  const list = document.getElementById('cmtList');
  if(!cmts.length) {
    list.innerHTML='<p style="color:var(--text-dim);font-style:italic;font-size:.84rem;padding:6px 0">Soyez le premier à commenter cette œuvre !</p>';
    return;
  }
  list.innerHTML = cmts.map(c=>`
    <div class="cmt-item">
      <div class="cmt-author-row">
        <span class="cmt-author">${esc(c.author_name)}</span>
        <span class="cmt-date">${(c.created_at||'').slice(0,10)}</span>
      </div>
      <div class="cmt-text">${esc(c.content)}</div>
    </div>`).join('');
}

document.getElementById('cSubmit').addEventListener('click', async () => {
  if(!activeDrawing) return;
  const author  = document.getElementById('cAuthor').value.trim();
  const content = document.getElementById('cContent').value.trim();
  const msg     = document.getElementById('cMsg');
  msg.className = 'form-msg';
  if(author.length<2||content.length<5) {
    msg.className='form-msg error'; msg.textContent='Nom (min 2) et message (min 5 caractères) requis.'; return;
  }
  try {
    const res  = await fetch(`${API}?action=comment`,{
      method:'POST', headers:{'Content-Type':'application/json'},
      body: JSON.stringify({drawing_id:activeDrawing.id,author_name:author,content})
    });
    const data = await res.json();
    if(data.success) {
      msg.className='form-msg success'; msg.textContent=data.message;
      document.getElementById('cAuthor').value=''; document.getElementById('cContent').value='';
    } else { msg.className='form-msg error'; msg.textContent=data.error||'Erreur.'; }
  } catch { msg.className='form-msg error'; msg.textContent='Serveur inaccessible.'; }
});

// ─────────────────────────────────────────
// 10. NAV ACTIVE + INIT v2.1
// ─────────────────────────────────────────
window.addEventListener('scroll', () => {
  const y = scrollY + 80;
  document.querySelectorAll('section[id]').forEach(s => {
    if (y >= s.offsetTop && y < s.offsetTop + s.offsetHeight) {
      document.querySelectorAll('.nav-links a').forEach(a =>
        a.classList.toggle('active', a.getAttribute('href') === '#' + s.id)
      );
    }
  });
});

// Bouton retour navigateur
window.addEventListener('popstate', () => {
  readURLParams();
  syncUIFromState();
  loadDrawings(true);
});

// Démarrage
readURLParams();
syncUIFromState();
loadDrawings(true);
loadTagsCloud();
</script>
</body>
</html>
