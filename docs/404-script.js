// Afficher des messages de console pour faciliter le débogage
console.log("Script 404-script.js chargé");

document.addEventListener('DOMContentLoaded', function() {
  console.log("DOM chargé");
  
  // Récupérer les éléments du DOM
  const startButton = document.getElementById('start-game');
  const restartButton = document.getElementById('restart-game');
  const gameArea = document.getElementById('game-area');
  const gameOver = document.getElementById('game-over');
  const gameInstructions = document.querySelector('.game-instructions');
  const player = document.getElementById('player');
  const guard = document.getElementById('guard');
  const bullet = document.getElementById('bullet');
  const scoreDisplay = document.getElementById('score-display');
  
  // Vérifier que tous les éléments sont bien récupérés
  console.log("Éléments trouvés:", { 
    startButton: !!startButton, 
    restartButton: !!restartButton, 
    gameArea: !!gameArea, 
    gameOver: !!gameOver, 
    gameInstructions: !!gameInstructions, 
    player: !!player, 
    guard: !!guard, 
    bullet: !!bullet, 
    scoreDisplay: !!scoreDisplay 
  });
  
  // Variables du jeu
  let isJumping = false;
  let isGameOver = false;
  let guardPosition = 1000;
  let bulletPosition = -100;
  let isBulletActive = false;
  let score = 0;
  let playerBottom = 40; // Distance du bas (au-dessus du sol)
  let jumpHeight = 0;
  let maxJumpHeight = 130;
  let gravity = 0.9;
  let isJumpingUp = true;
  let gameSpeed = 4;
  let jumpInterval = null; // Pour stocker l'intervalle de saut
  let guardTimer = null; // Pour stocker l'intervalle d'animation du garde
  let floorTimer = null; // Pour stocker l'intervalle d'animation du sol
  
  // Fonction pour démarrer le jeu
  function startGame() {
    console.log("Jeu démarré");
    
    // Arrêter tous les intervalles précédents
    if (jumpInterval) clearInterval(jumpInterval);
    if (guardTimer) clearInterval(guardTimer);
    if (floorTimer) clearInterval(floorTimer);
    
    // Réinitialiser les états
    gameInstructions.classList.add('hidden');
    gameArea.classList.remove('hidden');
    gameOver.classList.add('hidden');
    
    // Vérifier que gameArea est visible
    console.log("gameArea visible:", !gameArea.classList.contains('hidden'));
    
    isGameOver = false;
    isJumping = false; // Important : réinitialiser l'état de saut
    guardPosition = 1000;
    bulletPosition = -100;
    isBulletActive = false;
    score = 0;
    gameSpeed = 4;
    playerBottom = 40;
    
    // Positionner les éléments
    player.style.bottom = '40px';
    player.style.left = '50px';
    
    guard.style.left = `${guardPosition}px`;
    guard.style.bottom = '40px';
    
    bullet.style.left = `${bulletPosition}px`;
    bullet.classList.add('hidden');
    
    // Mettre à jour le score
    scoreDisplay.textContent = `Score: ${score}`;
    
    // Animation du garde et des projectiles
    guardTimer = setInterval(() => {
      if (isGameOver) {
        clearInterval(guardTimer);
        return;
      }
      
      // Augmenter la vitesse avec le score
      if (score > 100) {
        gameSpeed = Math.min(15, 5 + Math.floor(score / 2));
      }
      
      // Déplacement du garde
      guardPosition -= gameSpeed;
      guard.style.left = `${guardPosition}px`;
      
      // Tirer aléatoirement
      if (!isBulletActive && Math.random() < 0.01) {
        isBulletActive = true;
        bulletPosition = guardPosition - 20;
        bullet.style.left = `${bulletPosition}px`;
        bullet.classList.remove('hidden');
      }
      
      // Déplacement de la balle
      if (isBulletActive) {
        bulletPosition -= gameSpeed * 2;
        bullet.style.left = `${bulletPosition}px`;
        
        // Vérifier collision avec balle
        const playerRect = player.getBoundingClientRect();
        const bulletRect = bullet.getBoundingClientRect();
        
        if (
          bulletRect.left <= playerRect.right - 10 &&
          bulletRect.right >= playerRect.left + 10 &&
          bulletRect.top <= playerRect.bottom - 10 &&
          bulletRect.bottom >= playerRect.top + 10
        ) {
          endGame();
        }
        
        // Réinitialiser la balle si elle sort de l'écran
        if (bulletPosition < -100) {
          isBulletActive = false;
          bullet.classList.add('hidden');
        }
      }
      
      // Vérifier collision avec garde
      const playerRect = player.getBoundingClientRect();
      const guardRect = guard.getBoundingClientRect();
      
      if (
        guardRect.left <= playerRect.right - 15 &&
        guardRect.right >= playerRect.left + 15 &&
        guardRect.top <= playerRect.bottom - 15 &&
        guardRect.bottom >= playerRect.top + 15
      ) {
        endGame();
      }
      
      // Réinitialiser la position du garde
      if (guardPosition < -100) {
        guardPosition = 1000 + Math.random() * 500;
        score += 100;
        scoreDisplay.textContent = `Score: ${score}`;
      }
    }, 20);
    
    // Animation du sol défilant
    let floorPosition = 0;
    floorTimer = setInterval(() => {
      if (isGameOver) {
        clearInterval(floorTimer);
        return;
      }
      
      floorPosition -= gameSpeed;
      if (floorPosition <= -300) {
        floorPosition = 0;
      }
      document.getElementById('floor').style.backgroundPosition = `${floorPosition}px 0`;
      
    }, 20);
  }
  
  // Fonction pour faire sauter le joueur
  function jump() {
    if (isJumping || isGameOver) return;
    
    console.log("Saut");
    
    // Nettoyer tout intervalle de saut précédent
    if (jumpInterval) clearInterval(jumpInterval);
    
    isJumping = true;
    isJumpingUp = true;
    jumpHeight = 0;
    
    jumpInterval = setInterval(() => {
      if (isGameOver) {
        clearInterval(jumpInterval);
        isJumping = false; // Important: réinitialiser quand le jeu est terminé
        return;
      }
      
      // Phase de montée
      if (isJumpingUp) {
        jumpHeight += 7;
        playerBottom += 7;
        if (jumpHeight >= maxJumpHeight) {
          isJumpingUp = false;
        }
      } 
      // Phase de descente
      else {
        jumpHeight -= gravity * 5;
        playerBottom -= gravity * 5;
        if (playerBottom <= 40) {
          clearInterval(jumpInterval);
          playerBottom = 40;
          isJumping = false;
        }
      }
      
      player.style.bottom = `${playerBottom}px`;
    }, 20);
  }
  
  // Fonction de fin de jeu
  function endGame() {
    console.log("Game Over");
    
    // Arrêter tous les intervalles
    if (jumpInterval) {
      clearInterval(jumpInterval);
      jumpInterval = null;
    }
    
    isGameOver = true;
    isJumping = false; // Important : réinitialiser l'état de saut
    
    setTimeout(() => {
      gameArea.classList.add('hidden');
      gameOver.classList.remove('hidden');
    }, 800);
  }
  
  // Événements
  startButton.addEventListener('click', function() {
    console.log("Bouton start cliqué");
    startGame();
  });
  
  restartButton.addEventListener('click', function() {
    console.log("Bouton restart cliqué");
    startGame();
  });
  
  document.addEventListener('keydown', function(event) {
    if (event.code === 'Space') {
      event.preventDefault();
      jump();
    }
  });
  
  // Support tactile pour mobiles
  gameArea.addEventListener('touchstart', function(event) {
    event.preventDefault();
    jump();
  });
});
