import React, { useState, useEffect } from "react";
import Card from "./components/Card";
import "./index.css";
import { FaReact, FaHtml5, FaCss3Alt, FaNodeJs, FaGithub, FaNpm, FaVuejs, FaAngular } from "react-icons/fa";
import { SiJavascript, SiNextdotjs } from "react-icons/si";

const ICONS = [
  { name: "React", icon: <FaReact color="#61dafb" size={40} /> },
  { name: "HTML5", icon: <FaHtml5 color="#e34c26" size={40} /> },
  { name: "CSS3", icon: <FaCss3Alt color="#2965f1" size={40} /> },
  { name: "JavaScript", icon: <SiJavascript color="#f7df1e" size={40} /> },
  { name: "Node.js", icon: <FaNodeJs color="#3c873a" size={40} /> },
  { name: "GitHub", icon: <FaGithub color="#333" size={40} /> },
  { name: "NPM", icon: <FaNpm color="#cb3837" size={40} /> },
  { name: "Next.js", icon: <SiNextdotjs color="#000" size={40} /> },
  { name: "Vue.js", icon: <FaVuejs color="#42b883" size={40} /> },
  { name: "Angular", icon: <FaAngular color="#dd0031" size={40} /> },
];

function shuffle(array) {
  return array
    .concat(array)
    .sort(() => Math.random() - 0.5)
    .map((icon, idx) => ({ id: idx, ...icon }));
}

function App() {
  const [cards, setCards] = useState([]);
  const [flipped, setFlipped] = useState([]);
  const [matched, setMatched] = useState([]);
  const [victory, setVictory] = useState(false);

  useEffect(() => {
    handleRestart();
  }, []);

  useEffect(() => {
    if (matched.length === ICONS.length * 2) setVictory(true);
  }, [matched]);

  const handleCardClick = (idx) => {
    if (flipped.length === 2 || flipped.includes(idx)) return;
    const newFlipped = [...flipped, idx];
    setFlipped(newFlipped);

    if (newFlipped.length === 2) {
      const [first, second] = newFlipped;
      if (cards[first].name === cards[second].name) {
        setMatched([...matched, first, second]);
        setTimeout(() => setFlipped([]), 1000);
      } else {
        setTimeout(() => setFlipped([]), 1000);
      }
    }
  };

  const handleRestart = () => {
    setCards(shuffle(ICONS));
    setFlipped([]);
    setMatched([]);
    setVictory(false);
  };

  return (
    <div className="app">
      <h1 className="memory-title">Memory des Technologies Web 🚀</h1>
      <p className="subtitle">Retrouve toutes les paires de technologies web aussi vite que possible !</p>
      <button className="btn" onClick={handleRestart}>Recommencer</button>
      <div className="grid">
        {cards.map((card, idx) => (
          <Card
            key={card.id}
            card={card}
            onClick={() => handleCardClick(idx)}
            isFlipped={flipped.includes(idx)}
            isMatched={matched.includes(idx)}
          />
        ))}
      </div>
      {victory && <div className="victory">Bravo, tu as gagné !</div>}
    </div>
  );
}

export default App;
